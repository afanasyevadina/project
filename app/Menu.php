<?php

namespace App;
use App\Group;

class Menu
{
    public static function menu($route)
    {
        $list = [
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
                ],
            ],
            [
                'label' => 'Учебный план',
                'class' => '',
                'children' => [
                    [
                        'label' => 'План учебного процесса',
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
                        'label' => 'Рабочий учебный план',
                        'path' => 'rup',
                        'name' => 'rup',
                        'class' => '',
                        'roles' => ['admin', 'manager'],
                    ],
                    [
                        'label' => 'Нагрузка преподавателя',
                        'path' => 'load',
                        'name' => 'load',
                        'class' => '',
                        'roles' => ['admin', 'manager', 'teacher'],
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
                'roles' => ['*'],
            ],
        ];
        $menu = [];
        $role = \Auth::user()->role;
        if($role == 'teacher') {
            foreach(Group::where('teacher_id', \Auth::user()->person_id)->get() as $group) {
                $list[] = [
                    'label' => 'Студенты '.$group->name,
                    'path' => 'groups/'.$group->id.'/students',
                    'name' => 'group/students',
                    'class' => '',
                    'roles' => ['teacher'],
                ];
            }
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
                        $menu[$key]['children'][] = $subItem;
                    }
                }
            } else {
                if(in_array($role, $item['roles']) || in_array('*', $item['roles'])) {
                    $item['class'] =  $route == $item['name'] ? 'active bg-dark' : '';
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
        return date('d').' '.$m[date('n') - 1].' '.date('Y').' г., '.date('H:i');
    }
}
