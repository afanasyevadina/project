<?php

namespace App;
use App\Group;
use App\Message;
use Illuminate\Support\Facades\Gate;

class Menu
{
    public static function menu($route)
    {
        $list = [
            [
                'label' => 'Главная',
                'path' => 'home',
                'name' => 'home',
                'class' => '',
                'roles' => ['*'],
            ],
            [
                'label' => 'Администрирование',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Список пользователей',
                        'path' => 'admin/users',
                        'name' => 'admin/users',
                        'class' => '',
                        'roles' => ['admin'],
                    ],
                    [
                        'label' => 'Добавить пользователя',
                        'path' => 'admin/users/create',
                        'name' => 'admin/users/create',
                        'class' => '',
                        'roles' => ['admin'],
                    ],
                ]
            ],
            [
                'label' => 'Личная карта',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Студенты',
                        'path' => 'students',
                        'name' => 'students',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Преподаватели',
                        'path' => 'teachers',
                        'name' => 'teachers',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                ],
            ],
            [
                'label' => 'Каталог',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Специальности',
                        'path' => 'specializations',
                        'name' => 'specializations',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Группы',
                        'path' => 'groups',
                        'name' => 'groups',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Аудиторный фонд',
                        'path' => 'cabs',
                        'name' => 'cabs',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Дисциплины',
                        'path' => 'subjects',
                        'name' => 'subjects',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Циклы дисциплин',
                        'path' => 'cikls',
                        'name' => 'cikls',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                ],
            ],
            [
                'label' => 'Просмотр расписания',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Основное расписание',
                        'path' => 'schedule',
                        'name' => 'schedule',
                        'class' => '',
                        'roles' => ['*'],
                    ],
                    [
                        'label' => 'Изменения в расписании',
                        'path' => 'changes',
                        'name' => 'changes',
                        'class' => '',
                        'roles' => ['*'],
                    ],
                    [
                        'label' => 'График экзаменов',
                        'path' => 'exams',
                        'name' => 'exams',
                        'class' => '',
                        'roles' => ['*'],
                    ],
                ],
            ],
            [
                'label' => 'Редактор расписания',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Основное расписание',
                        'path' => 'schedule/edit',
                        'name' => 'schedule/edit',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'dispatcher'],
                    ],
                    [
                        'label' => 'Изменения в расписании',
                        'path' => 'changes/edit',
                        'name' => 'changes/edit',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'dispatcher'],
                    ],
                    [
                        'label' => 'График экзаменов',
                        'path' => 'exams/edit',
                        'name' => 'exams/edit',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'dispatcher'],
                    ],
                    [
                        'label' => 'Праздничные дни',
                        'path' => 'holidays',
                        'name' => 'holidays',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'dispatcher'],
                    ],
                ],
            ],
            [
                'label' => 'Выходные данные',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Форма 2',
                        'path' => 'doc/form2',
                        'name' => 'form2',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'dispatcher'],
                    ],
                    [
                        'label' => 'Форма 3',
                        'path' => 'doc/form3',
                        'name' => 'form3',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'dispatcher'],
                    ],
                    [
                        'label' => 'Нагрузка преподавателя',
                        'path' => 'load',
                        'name' => 'load',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
                    ],
                ],
            ],
            [
                'label' => 'Учебный план',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Рабочий учебный план',
                        'path' => 'plans',
                        'name' => 'plans',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'График учебного процесса',
                        'path' => 'graphic',
                        'name' => 'graphic',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Годовой план',
                        'path' => 'rup',
                        'name' => 'rup',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Рабочая учебная программа',
                        'path' => 'rp',
                        'name' => 'rp',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
                    ],
                    [
                        'label' => 'Календарно-тематический план',
                        'path' => 'ktp',
                        'name' => 'ktp',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
                    ],
                ],
            ],
            [
                'label' => 'Журналы',
                'class' => '',
                'children' => [
                    [
                        'label' => 'Журналы успеваемости',
                        'path' => 'journal',
                        'name' => 'journal',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
                    ],
                    [
                        'label' => 'Текущая успеваемость',
                        'path' => 'journal/report',
                        'name' => 'journal/report',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
                    ],
                    [
                        'label' => 'Аттестация',
                        'path' => 'results',
                        'name' => 'results',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
                    ],
                ],
            ],
            [
                'label' => 'Личная карта',
                'path' => 'students/'.\Auth::user()->person_id,
                'name' => 'students',
                'class' => '',
                'roles' => ['student'],
            ],
            [
                'label' => 'Личная карта',
                'path' => 'teachers/'.\Auth::user()->person_id,
                'name' => 'teachers',
                'class' => '',
                'roles' => ['teacher'],
            ],
            [
                'label' => 'Моя зачетка',
                'path' => 'results/'.\Auth::user()->person_id,
                'name' => 'zachetka',
                'class' => '',
                'roles' => ['student'],
            ],
            [
                'label' => 'Форум',
                'path' => 'forum',
                'name' => 'forum',
                'class' => '',
                'roles' => ['student', 'teacher', 'admin'],
            ],
            [
                'label' => 'Топ - 100',
                'path' => 'statistic/top',
                'name' => 'statistic/top',
                'class' => '',
                'roles' => ['*'],
            ],
            [
                'label' => 'Моя динамика',
                'path' => 'statistic/dynamic',
                'name' => 'statistic/dynamic',
                'class' => '',
                'roles' => ['student'],
            ],
        ];
        $menu = [];
        $user = \Auth::user();
        $role = $user->role;
        if($role == 'teacher') {
            foreach(Group::where('teacher_id', $user->person_id)->get() as $group) {
                $list[] = [
                    'label' => 'Студенты '.$group->name,
                    'path' => 'groups/'.$group->id.'/students',
                    'name' => 'group/students',
                    'class' => '',
                    'roles' => ['teacher'],
                ];
            }
            $list[] = [
                'label' => 'Расписание на сегодня',
                'path' => 'changes/teacher?date='.date('Y-m-d').'&teacher='.$user->person_id,
                'name' => 'changes/today',
                'class' => '',
                'roles' => ['teacher'],
            ];
        }
        if($role == 'student') {
            $list[] = [
                'label' => 'Расписание на сегодня',
                'path' => 'changes/group?date='.date('Y-m-d').'&group='.$user->person->group_id,
                'name' => 'changes/today',
                'class' => '',
                'roles' => ['student'],
            ];
        }
        $unread = 0;        
        if(Gate::allows('forum')) {
            $userid = \Auth::user()->id;
            $unread = Message::where('for_owner', $userid)->orWhere('for_reply', $userid)->count();
        }
        foreach ($list as $key => $item) {
            if(isset($item['children'])) {
                foreach ($item['children'] as $subItem) {
                    if(in_array($role, $subItem['roles']) || in_array('*', $subItem['roles'])) {
                        if(!isset($menu[$key])) {
                            $menu[$key] = $item;
                            $menu[$key]['children'] = [];
                        }
                        if($route == $subItem['name']) {
                            $subItem['class'] =  'active bg-dark';
                            $menu[$key]['class'] =  'show';
                        }
                        if($subItem['name'] == 'forum' && $unread) {
                            $subItem['badge'] = $unread;
                        }
                        $menu[$key]['children'][] = $subItem;
                    }
                }
            } else {
                if(in_array($role, $item['roles']) || in_array('*', $item['roles'])) {
                    $item['class'] =  $route == $item['name'] ? 'active bg-dark' : '';
                    if($item['name'] == 'forum' && $unread) {
                        $item['badge'] = $unread;
                    }
                    $menu[$key] = $item;
                }
            }
        }
        return $menu;
    }

    public static function now()
    {
        $m = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
        $d = ['понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье'];
        return date('d', time()+3600*6).' '.$m[date('n', time()+3600*6) - 1].' '.date('Y', time()+3600*6).', '.date('H:i', time()+3600*6);
    }

    public static function greeting($name, $role = 'student')
    {
        $greetings = [
            'student' => [
                'Привет, {name}, как настроение?',
                '{name}! Вот уж не ждали сегодня!',
                '{name}, я, конечно, не эксперт, но учеба очень важна.',
                'Знаешь, {name}, иногда лучше просто смириться.',
                '{name}, ты справишься! Вот я точно знаю.',
            ],
            'teacher' => [
                'Здравствуйте, {name}, как настроение?',
                '{name}! Рад вас видеть!',
                '{name}, мы очень ценим Ваше мнение, но свое тоже.',
                'Знаете, {name}, иногда лучше просто смириться.',
                '{name}, Вы справитесь! Вот я точно знаю.',
            ]
        ];
        return @str_replace('{name}', $name, $greetings[$role][random_int(0, count($greetings[$role]) - 1)]);
    }
}
