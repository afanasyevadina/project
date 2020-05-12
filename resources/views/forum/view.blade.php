@extends('layouts.app')
@section('title', 'Форум | '.$topic->name)
@section('content')
@verbatim
<div id="app" class="chat">
	<div class="card" v-if="topic">
		<div class="card-header d-flex justify-content-between">
			<h5 class="mb-0">{{ topic.name }}</h5>
			<small class="text-muted">Создана пользователем {{ topic.user.name }}<br>{{ topic.date }} в {{ topic.time }}</small>
		</div>
		<div class="card-body bg-light py-2">
			{{ topic.description }}
		</div>
	</div>
	<div class="messages border-right border-left mb-2 p-2 overflow-auto" ref="room">
		<template v-if="messages">
			<button class="btn btn-sm btn-outline-info d-block mx-auto mb-2" @click="load" v-if="hasMore">
				Загрузить еще
			</button>
			<div v-for="(message, m) in messages" :key="message.id">
				<p v-if="!messages[m-1]||messages[m-1].date!=message.date" class="text-muted text-center">
					{{message.date}}
				</p>
				<div class="d-flex align-items-end mb-3" :class="{'flex-row-reverse': message.user_id==user.id}">
					<div class="card message" :id="message.id">
						<div class="card-body p-2 rounded" :class="{'bg-secondary text-white': message.user_id==user.id}">
							<span class="d-block font-weight-bold" v-if="message.user_id!=user.id">
								{{ message.user.name }}
							</span>
							{{ message.text }}
							<img v-if="message.hasImage" :src="message.file" class="d-block mt-2" width="500">
							<a v-else-if="message.file" :href="message.file" class="d-block mt-2">
								<img src="/public/img/icons/document.svg" height="20" class="mr-1" 
								:class="{'white-img': message.user_id==user.id}">
								{{message.file.split('/').pop()}}
							</a>
							<div v-if="message.reply" class="pl-2 border-left mt-2">
								<a :href="'#'+message.reply.id" class="hover-none">
									<small class="d-block font-weight-bold">
										{{ message.reply.user_id == user.id ? 'Вы' : message.reply.user.name }}
									</small>
								</a>
								<small>{{ message.reply.text }}</small>
								<img v-if="message.reply.hasImage" :src="message.reply.file" class="d-block mt-2" width="450">
								<a v-else-if="message.reply.file" :href="message.reply.file">
									<img src="/public/img/icons/document.svg" height="18" class="mr-1" 
									:class="{'white-img': message.user_id==user.id}">
									{{message.reply.file.split('/').pop()}}
								</a>
							</div>
						</div>
					</div>
					<small class="text-muted mx-2">{{ message.time }}</small>
					<small class="text-muted mx-2 mb-1 reply-link" @click="reply = message">
						<img src="/public/img/icons/reply.svg" height="15"  @click="reply = message">
					</small>
				</div>
			</div>
		</template>
		<template v-else><div class="loader"></div></template>
		<div id="last"></div>
	</div>
	<form @submit.prevent="send">
		<div class="card bg-light" v-if="reply">
			<div class="card-body p-2">
				<small class="font-weight-bold">{{ reply.user.name }}</small>
				<button type="button" class="close" @click="reply=null">
					<span aria-hidden="true">&times;</span>
				</button>
				<small class="d-block">{{ reply.text }}</small>
				<small v-if="reply.file" class="d-block">*вложение*</small>
			</div>
		</div>
		<div class="card bg-light" v-if="file">
			<div class="card-body p-2">
				<small class="font-weight-bold">{{ file.name }}</small>
				<button type="button" class="close" @click="file=''">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<div class="input-group">
			<div class="input-group-prepend">
				<label for="file" class="input-group-text" style="cursor: pointer;">
					<img src="/public/img/icons/paperclip.svg" height="20" class="muted-img">
				</label>
				<input type="file" name="file" class="d-none" id="file" @change="setFile" ref="file">
			</div>
			<input type="text" class="form-control" placeholder="Ваше сообщение" v-model="message" autocomplete="off" autofocus>
			<div class="input-group-append">
				<button type="submit" class="input-group-text bg-primary text-white">Отправить</button>
			</div>
		</div>
	</form>
</div>
@endverbatim
@endsection
@section('scripts')
<script type="text/javascript">
	const app = new Vue({
		el: '#app',
		data: {
			hasMore: false,
			topic: null,
			user: null,
			messages: [],
			message: '',
			file: '',
			reply: null
		},
		methods: {
			send: function() {
				if(this.message || this.file) {
					var formData = new FormData()
					formData.append('text', this.message)
					formData.append('topic_id', this.topic.id)
					if(this.reply) {
						formData.append('reply_id', this.reply.id)
					}
					if(this.file) {
						formData.append('file', this.file)
					}
					var options = this.file ? {
						headers: {'Content-Type': 'multipart/form-data'}
					} : null
					axios.post('/api/forum?api_token=' + this.user.api_token, formData, options)
					.then(response => {
						this.messages.push(response.data)
						this.message = ''
						this.file = ''
						this.reply = null
						this.$refs.room.scrollTo(0, this.$refs.room.scrollHeight * 2)
					})
				}
			},
			load: function() {
				return new Promise((resolve, reject) => {
					axios.get('/api/forum/' + this.topic.id + 
						'?api_token=' + this.user.api_token +
						'&skip=' + this.messages.length)
					.then(response => {
						this.messages = response.data.reverse().concat(this.messages)
						this.hasMore = response.data.length >= 10
						resolve()
					})
				})
			},
			setFile: function() {
				this.file = this.$refs.file.files[0]
			}
		},
		created() {			
			this.topic = <?=json_encode($topic)?>;
			this.user = <?=json_encode(\Auth::user())?>;
			this.load().then(() => this.$refs.room.scrollTo(0, this.$refs.room.scrollHeight))
		}
	});
</script>
@endsection