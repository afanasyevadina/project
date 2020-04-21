@extends('layouts.app')
@section('title', $topic->name)
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
			<button class="btn btn-sm btn-outline-info d-block m-auto mb-2" @click="load" v-if="hasMore">
				Загрузить еще
			</button>
			<div class="d-flex align-items-end mb-3" 
			:class="{'flex-row-reverse': message.user_id==user.id}" 
			v-for="message in messages" :key="message.id">
				<div class="card message">
					<div class="card-body p-2 rounded" :class="{'bg-secondary text-white': message.user_id==user.id}">
						<span class="d-block font-weight-bold" v-if="message.user_id!=user.id">
							{{ message.user.name }}
						</span>
						{{ message.text }}
						<div v-if="message.reply" class="pl-2 border-left mt-2">
							<small class="d-block font-weight-bold">
								{{ message.reply.user_id == user.id ? 'Вы' : message.reply.user.name }}
							</small>
							<small>{{ message.reply.text }}</small>
						</div>
					</div>
				</div>
				<small class="text-muted mx-2">{{ message.time }}</small>
				<small class="text-muted mx-2 reply-link" @click="reply = message">Ответить</small>
			</div>
		</template>
		<template v-else><div class="loader"></div></template>
	</div>
	<form @submit.prevent="send">
		<div class="card bg-light" v-if="reply">
			<div class="card-body p-2">
				<small class="font-weight-bold">{{ reply.user.name }}</small>
				<button type="button" class="close" @click="reply=null">
				    <span aria-hidden="true">&times;</span>
				</button>
				<small class="d-block">{{ reply.text }}</small>
			</div>
		</div>
		<div class="input-group">
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
			reply: null
		},
		methods: {
			send: function() {
				if(this.message) {
					axios.post('/api/forum?api_token=' + this.user.api_token, {
						topic_id: this.topic.id,
						text: this.message,
						reply_id: this.reply ? this.reply.id : null
					})
					.then(response => {
						this.messages.push(response.data)
						this.message = ''
						this.reply = null
						this.$refs.room.scrollTo(0, this.$refs.room.scrollHeight * 2)
					})
				}
			},
			load: function() {
				axios.get('/api/forum/' + this.topic.id + 
					'?api_token=' + this.user.api_token +
					'&skip=' + this.messages.length)
				.then(response => {
					this.messages = response.data.reverse().concat(this.messages)
					this.hasMore = response.data.length >= 10
				})
			}
		},
		created() {			
			this.topic = <?=json_encode($topic)?>;
			this.user = <?=json_encode(\Auth::user())?>;
			this.load()
		},
		mounted() {
			this.$refs.room.scrollTo(0, this.$refs.room.scrollHeight)
		}
	});
</script>
@endsection