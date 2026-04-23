<?php

return [
    'navigation' => [
        'title' => 'Пользовательские поля',
        'group' => 'Настройки',
    ],

    'form' => [
        'sections' => [
            'general' => [
                'fields' => [
                    'name'              => 'Название',
                    'code'              => 'Код',
                    'code-helper-text'  => 'Код должен начинаться с буквы или подчёркивания и содержать только буквы, цифры и подчёркивания.',
                ],
            ],

            'options' => [
                'title' => 'Варианты',

                'fields' => [
                    'add-option' => 'Добавить вариант',
                ],
            ],

            'form-settings' => [
                'title' => 'Настройки формы',

                'field-sets' => [
                    'validations' => [
                        'title' => 'Валидация',

                        'fields' => [
                            'validation'     => 'Правило',
                            'field'          => 'Поле',
                            'value'          => 'Значение',
                            'add-validation' => 'Добавить правило',
                        ],
                    ],

                    'additional-settings' => [
                        'title' => 'Дополнительные настройки',

                        'fields' => [
                            'setting'     => 'Параметр',
                            'value'       => 'Значение',
                            'color'       => 'Цвет',
                            'add-setting' => 'Добавить параметр',

                            'color-options' => [
                                'danger'    => 'Опасность',
                                'info'      => 'Информация',
                                'primary'   => 'Основной',
                                'secondary' => 'Второстепенный',
                                'warning'   => 'Предупреждение',
                                'success'   => 'Успех',
                            ],

                            'grid-options' => [
                                'row'    => 'Строка',
                                'column' => 'Колонка',
                            ],

                            'input-modes' => [
                                'text'     => 'Текст',
                                'email'    => 'Email',
                                'numeric'  => 'Числовой',
                                'integer'  => 'Целое число',
                                'password' => 'Пароль',
                                'tel'      => 'Телефон',
                                'url'      => 'URL',
                                'color'    => 'Цвет',
                                'none'     => 'Нет',
                                'decimal'  => 'Десятичный',
                                'search'   => 'Поиск',
                            ],
                        ],
                    ],
                ],

                'validations' => [
                    'common' => [
                        'gt'                   => 'Больше чем',
                        'gte'                  => 'Больше или равно',
                        'lt'                   => 'Меньше чем',
                        'lte'                  => 'Меньше или равно',
                        'max-size'             => 'Максимальный размер',
                        'min-size'             => 'Минимальный размер',
                        'multiple-of'          => 'Кратно',
                        'nullable'             => 'Может быть пустым',
                        'prohibited'           => 'Запрещено',
                        'prohibited-if'        => 'Запрещено, если',
                        'prohibited-unless'    => 'Запрещено, если не',
                        'prohibits'            => 'Запрещает',
                        'required'             => 'Обязательно',
                        'required-if'          => 'Обязательно, если',
                        'required-if-accepted' => 'Обязательно, если принято',
                        'required-unless'      => 'Обязательно, если не',
                        'required-with'        => 'Обязательно с',
                        'required-with-all'    => 'Обязательно со всеми',
                        'required-without'     => 'Обязательно без',
                        'required-without-all' => 'Обязательно без всех',
                        'rules'                => 'Пользовательские правила',
                        'unique'               => 'Уникально',
                    ],

                    'text' => [
                        'alpha-dash'        => 'Буквы, цифры, дефис и подчёркивание',
                        'alpha-num'         => 'Буквы и цифры',
                        'ascii'             => 'ASCII',
                        'doesnt-end-with'   => 'Не заканчивается на',
                        'doesnt-start-with' => 'Не начинается с',
                        'ends-with'         => 'Заканчивается на',
                        'filled'            => 'Заполнено',
                        'ip'                => 'IP-адрес',
                        'ipv4'              => 'IPv4',
                        'ipv6'              => 'IPv6',
                        'length'            => 'Длина',
                        'mac-address'       => 'MAC-адрес',
                        'max-length'        => 'Максимальная длина',
                        'min-length'        => 'Минимальная длина',
                        'regex'             => 'Регулярное выражение',
                        'starts-with'       => 'Начинается с',
                        'ulid'              => 'ULID',
                        'uuid'              => 'UUID',
                    ],

                    'textarea' => [
                        'filled'     => 'Заполнено',
                        'max-length' => 'Максимальная длина',
                        'min-length' => 'Минимальная длина',
                    ],

                    'select' => [
                        'different'  => 'Отличается',
                        'exists'     => 'Существует',
                        'in'         => 'Входит в',
                        'not-in'     => 'Не входит в',
                        'same'       => 'Совпадает',
                    ],

                    'radio' => [],

                    'checkbox' => [
                        'accepted' => 'Принято',
                        'declined' => 'Отклонено',
                    ],

                    'toggle' => [
                        'accepted' => 'Принято',
                        'declined' => 'Отклонено',
                    ],

                    'checkbox-list' => [
                        'in'        => 'Входит в',
                        'max-items' => 'Максимум элементов',
                        'min-items' => 'Минимум элементов',
                    ],

                    'datetime' => [
                        'after'           => 'После',
                        'after-or-equal'  => 'После или равно',
                        'before'          => 'До',
                        'before-or-equal' => 'До или равно',
                    ],

                    'editor' => [
                        'filled'     => 'Заполнено',
                        'max-length' => 'Максимальная длина',
                        'min-length' => 'Минимальная длина',
                    ],

                    'markdown' => [
                        'filled'     => 'Заполнено',
                        'max-length' => 'Максимальная длина',
                        'min-length' => 'Минимальная длина',
                    ],

                    'color' => [
                        'hex-color' => 'HEX-цвет',
                    ],

                    'star-rating' => [
                    ],
                ],

                'settings' => [
                    'text' => [
                        'autocapitalize'    => 'Автокапитализация',
                        'autocomplete'      => 'Автозаполнение',
                        'autofocus'         => 'Автофокус',
                        'default'           => 'Значение по умолчанию',
                        'disabled'          => 'Отключено',
                        'helper-text'       => 'Подсказка',
                        'hint'              => 'Совет',
                        'hint-color'        => 'Цвет совета',
                        'hint-icon'         => 'Иконка совета',
                        'id'                => 'ID',
                        'input-mode'        => 'Режим ввода',
                        'mask'              => 'Маска',
                        'placeholder'       => 'Плейсхолдер',
                        'prefix'            => 'Префикс',
                        'prefix-icon'       => 'Иконка префикса',
                        'prefix-icon-color' => 'Цвет иконки префикса',
                        'read-only'         => 'Только для чтения',
                        'step'              => 'Шаг',
                        'suffix'            => 'Суффикс',
                        'suffix-icon'       => 'Иконка суффикса',
                        'suffix-icon-color' => 'Цвет иконки суффикса',
                    ],

                    'textarea' => [
                        'autofocus'    => 'Автофокус',
                        'autosize'     => 'Авторазмер',
                        'cols'         => 'Колонки',
                        'default'      => 'Значение по умолчанию',
                        'disabled'     => 'Отключено',
                        'helperText'   => 'Подсказка',
                        'hint'         => 'Совет',
                        'hintColor'    => 'Цвет совета',
                        'hintIcon'     => 'Иконка совета',
                        'id'           => 'ID',
                        'placeholder'  => 'Плейсхолдер',
                        'read-only'    => 'Только для чтения',
                        'rows'         => 'Строки',
                    ],

                    'select' => [
                        'default'                   => 'Значение по умолчанию',
                        'disabled'                  => 'Отключено',
                        'helper-text'               => 'Подсказка',
                        'hint'                      => 'Совет',
                        'hint-color'                => 'Цвет совета',
                        'hint-icon'                 => 'Иконка совета',
                        'id'                        => 'ID',
                        'loading-message'           => 'Сообщение о загрузке',
                        'no-search-results-message' => 'Нет результатов поиска',
                        'options-limit'             => 'Лимит вариантов',
                        'preload'                   => 'Предзагрузка',
                        'searchable'                => 'Доступен поиск',
                        'search-debounce'           => 'Задержка поиска',
                        'searching-message'         => 'Сообщение при поиске',
                        'search-prompt'             => 'Подсказка поиска',
                    ],

                    'radio' => [
                        'default'     => 'Значение по умолчанию',
                        'disabled'    => 'Отключено',
                        'helper-text' => 'Подсказка',
                        'hint'        => 'Совет',
                        'hint-color'  => 'Цвет совета',
                        'hint-icon'   => 'Иконка совета',
                        'id'          => 'ID',
                    ],

                    'checkbox' => [
                        'default'     => 'Значение по умолчанию',
                        'disabled'    => 'Отключено',
                        'helper-text' => 'Подсказка',
                        'hint'        => 'Совет',
                        'hint-color'  => 'Цвет совета',
                        'hint-icon'   => 'Иконка совета',
                        'id'          => 'ID',
                        'inline'      => 'В строку',
                    ],

                    'toggle' => [
                        'default'     => 'Значение по умолчанию',
                        'disabled'    => 'Отключено',
                        'helper-text' => 'Подсказка',
                        'hint'        => 'Совет',
                        'hint-color'  => 'Цвет совета',
                        'hint-icon'   => 'Иконка совета',
                        'id'          => 'ID',
                        'off-color'   => 'Цвет "выкл"',
                        'off-icon'    => 'Иконка "выкл"',
                        'on-color'    => 'Цвет "вкл"',
                        'on-icon'     => 'Иконка "вкл"',
                    ],

                    'checkbox-list' => [
                        'bulk-toggleable'           => 'Массовое переключение',
                        'columns'                   => 'Колонки',
                        'default'                   => 'Значение по умолчанию',
                        'disabled'                  => 'Отключено',
                        'grid-direction'            => 'Направление сетки',
                        'helper-text'               => 'Подсказка',
                        'hint'                      => 'Совет',
                        'hint-color'                => 'Цвет совета',
                        'hint-icon'                 => 'Иконка совета',
                        'id'                        => 'ID',
                        'max-items'                 => 'Максимум элементов',
                        'min-items'                 => 'Минимум элементов',
                        'no-search-results-message' => 'Нет результатов поиска',
                        'searchable'                => 'Доступен поиск',
                    ],

                    'datetime' => [
                        'close-on-date-selection' => 'Закрывать при выборе даты',
                        'default'                 => 'Значение по умолчанию',
                        'disabled'                => 'Отключено',
                        'disabled-dates'          => 'Запрещённые даты',
                        'display-format'          => 'Формат отображения',
                        'first-fay-of-week'       => 'Первый день недели',
                        'format'                  => 'Формат',
                        'helper-text'             => 'Подсказка',
                        'hint'                    => 'Совет',
                        'hint-color'              => 'Цвет совета',
                        'hint-icon'               => 'Иконка совета',
                        'hours-step'              => 'Шаг часов',
                        'id'                      => 'ID',
                        'locale'                  => 'Локаль',
                        'minutes-step'            => 'Шаг минут',
                        'seconds'                 => 'Секунды',
                        'seconds-step'            => 'Шаг секунд',
                        'timezone'                => 'Часовой пояс',
                        'week-starts-on-monday'   => 'Неделя с понедельника',
                        'week-starts-on-sunday'   => 'Неделя с воскресенья',
                    ],

                    'editor' => [
                        'default'      => 'Значение по умолчанию',
                        'disabled'     => 'Отключено',
                        'helper-text'  => 'Подсказка',
                        'hint'         => 'Совет',
                        'hint-color'   => 'Цвет совета',
                        'hint-icon'    => 'Иконка совета',
                        'id'           => 'ID',
                        'placeholder'  => 'Плейсхолдер',
                        'read-only'    => 'Только для чтения',
                    ],

                    'markdown' => [
                        'default'      => 'Значение по умолчанию',
                        'disabled'     => 'Отключено',
                        'helper-text'  => 'Подсказка',
                        'hint'         => 'Совет',
                        'hint-color'   => 'Цвет совета',
                        'hint-icon'    => 'Иконка совета',
                        'id'           => 'ID',
                        'placeholder'  => 'Плейсхолдер',
                        'read-only'    => 'Только для чтения',
                    ],

                    'color' => [
                        'default'     => 'Значение по умолчанию',
                        'disabled'    => 'Отключено',
                        'helper-text' => 'Подсказка',
                        'hint'        => 'Совет',
                        'hint-color'  => 'Цвет совета',
                        'hint-icon'   => 'Иконка совета',
                        'hsl'         => 'HSL',
                        'id'          => 'ID',
                        'rgb'         => 'RGB',
                        'rgba'        => 'RGBA',
                    ],

                    'star-rating' => [
                        'default'     => 'Значение по умолчанию',
                        'disabled'    => 'Отключено',
                        'helper-text' => 'Подсказка',
                        'hint'        => 'Совет',
                        'hint-color'  => 'Цвет совета',
                        'hint-icon'   => 'Иконка совета',
                        'id'          => 'ID',
                        'read-only'   => 'Только для чтения',
                    ],

                    'file' => [
                        'accepted-file-types'                   => 'Разрешённые типы файлов',
                        'append-files'                          => 'Добавлять файлы',
                        'deletable'                             => 'Можно удалять',
                        'directory'                             => 'Директория',
                        'downloadable'                          => 'Можно скачивать',
                        'fetch-file-information'                => 'Загружать информацию о файле',
                        'file-attachments-directory'            => 'Директория вложений',
                        'file-attachments-visibility'           => 'Видимость вложений',
                        'image'                                 => 'Изображение',
                        'image-crop-aspect-ratio'               => 'Соотношение сторон обрезки',
                        'image-editor'                          => 'Редактор изображений',
                        'image-editor-aspect-ratios'            => 'Соотношения сторон редактора',
                        'image-editor-empty-fill-color'         => 'Цвет пустой заливки',
                        'image-editor-mode'                     => 'Режим редактора',
                        'image-preview-height'                  => 'Высота предпросмотра',
                        'image-resize-mode'                     => 'Режим изменения размера',
                        'image-resize-target-height'            => 'Целевая высота',
                        'image-resize-target-width'             => 'Целевая ширина',
                        'loading-indicator-position'            => 'Позиция индикатора загрузки',
                        'move-files'                            => 'Перемещать файлы',
                        'openable'                              => 'Можно открывать',
                        'orient-images-from-exif'               => 'Ориентация по EXIF',
                        'panel-aspect-ratio'                    => 'Соотношение сторон панели',
                        'panel-layout'                          => 'Макет панели',
                        'previewable'                           => 'С превью',
                        'remove-uploaded-file-button-position'  => 'Позиция кнопки удаления',
                        'reorderable'                           => 'Можно сортировать',
                        'store-files'                           => 'Сохранять файлы',
                        'upload-button-position'                => 'Позиция кнопки загрузки',
                        'uploading-message'                     => 'Сообщение при загрузке',
                        'upload-progress-indicator-position'    => 'Позиция индикатора прогресса',
                        'visibility'                            => 'Видимость',
                    ],
                ],
            ],

            'table-settings' => [
                'title' => 'Настройки таблицы',

                'fields' => [
                    'use-in-table'  => 'Использовать в таблице',
                    'setting'       => 'Параметр',
                    'value'         => 'Значение',
                    'color'         => 'Цвет',
                    'alignment'     => 'Выравнивание',
                    'font-weight'   => 'Насыщенность шрифта',
                    'icon-position' => 'Позиция иконки',
                    'size'          => 'Размер',
                    'add-setting'   => 'Добавить параметр',

                    'color-options' => [
                        'danger'    => 'Опасность',
                        'info'      => 'Информация',
                        'primary'   => 'Основной',
                        'secondary' => 'Второстепенный',
                        'warning'   => 'Предупреждение',
                        'success'   => 'Успех',
                    ],

                    'alignment-options' => [
                        'start'   => 'Начало',
                        'left'    => 'Слева',
                        'center'  => 'По центру',
                        'end'     => 'Конец',
                        'right'   => 'Справа',
                        'justify' => 'По ширине',
                        'between' => 'Между',
                    ],

                    'font-weight-options' => [
                        'extra-light' => 'Экстра тонкий',
                        'light'       => 'Тонкий',
                        'normal'      => 'Обычный',
                        'medium'      => 'Средний',
                        'semi-bold'   => 'Полужирный',
                        'bold'        => 'Жирный',
                        'extra-bold'  => 'Экстра жирный',
                    ],

                    'icon-position-options' => [
                        'before'  => 'Перед',
                        'after'   => 'После',
                    ],

                    'size-options' => [
                        'extra-small' => 'Очень маленький',
                        'small'       => 'Маленький',
                        'medium'      => 'Средний',
                        'large'       => 'Большой',
                    ],
                ],

                'settings' => [
                    'common' => [
                        'align-end'              => 'Выравнивание к концу',
                        'alignment'              => 'Выравнивание',
                        'align-start'            => 'Выравнивание к началу',
                        'badge'                  => 'Бейдж',
                        'boolean'                => 'Булево',
                        'color'                  => 'Цвет',
                        'copyable'               => 'Копируемое',
                        'copy-message'           => 'Сообщение при копировании',
                        'copy-message-duration'  => 'Длительность сообщения',
                        'default'                => 'По умолчанию',
                        'filterable'             => 'Фильтруемое',
                        'groupable'              => 'Группируемое',
                        'grow'                   => 'Растягивать',
                        'icon'                   => 'Иконка',
                        'icon-color'             => 'Цвет иконки',
                        'icon-position'          => 'Позиция иконки',
                        'label'                  => 'Метка',
                        'limit'                  => 'Лимит',
                        'line-clamp'             => 'Ограничение строк',
                        'money'                  => 'Деньги',
                        'placeholder'            => 'Плейсхолдер',
                        'prefix'                 => 'Префикс',
                        'searchable'             => 'Доступен поиск',
                        'size'                   => 'Размер',
                        'sortable'               => 'Сортируемое',
                        'suffix'                 => 'Суффикс',
                        'toggleable'             => 'Переключаемое',
                        'tooltip'                => 'Подсказка',
                        'vertical-alignment'     => 'Вертикальное выравнивание',
                        'vertically-align-start' => 'Вертикально к началу',
                        'weight'                 => 'Насыщенность',
                        'width'                  => 'Ширина',
                        'words'                  => 'Слова',
                        'wrap-header'            => 'Перенос заголовка',
                        'column-span'            => 'Занимаемые колонки',
                        'helper-text'            => 'Подсказка',
                        'hint'                   => 'Совет',
                        'hint-color'             => 'Цвет совета',
                        'hint-icon'              => 'Иконка совета',
                    ],

                    'datetime' => [
                        'date'              => 'Дата',
                        'date-time'         => 'Дата и время',
                        'date-time-tooltip' => 'Подсказка даты и времени',
                        'since'             => 'Прошло времени',
                    ],
                ],
            ],

            'infolist-settings' => [
                'title' => 'Настройки инфолиста',

                'fields' => [
                    'setting'       => 'Параметр',
                    'value'         => 'Значение',
                    'color'         => 'Цвет',
                    'font-weight'   => 'Насыщенность шрифта',
                    'icon-position' => 'Позиция иконки',
                    'size'          => 'Размер',
                    'add-setting'   => 'Добавить параметр',

                    'color-options' => [
                        'danger'    => 'Опасность',
                        'info'      => 'Информация',
                        'primary'   => 'Основной',
                        'secondary' => 'Второстепенный',
                        'warning'   => 'Предупреждение',
                        'success'   => 'Успех',
                    ],

                    'font-weight-options' => [
                        'extra-light' => 'Экстра тонкий',
                        'light'       => 'Тонкий',
                        'normal'      => 'Обычный',
                        'medium'      => 'Средний',
                        'semi-bold'   => 'Полужирный',
                        'bold'        => 'Жирный',
                        'extra-bold'  => 'Экстра жирный',
                    ],

                    'icon-position-options' => [
                        'before'  => 'Перед',
                        'after'   => 'После',
                    ],

                    'size-options' => [
                        'extra-small' => 'Очень маленький',
                        'small'       => 'Маленький',
                        'medium'      => 'Средний',
                        'large'       => 'Большой',
                    ],
                ],

                'settings' => [
                    'common' => [
                        'align-end'              => 'Выравнивание к концу',
                        'alignment'              => 'Выравнивание',
                        'align-start'            => 'Выравнивание к началу',
                        'badge'                  => 'Бейдж',
                        'boolean'                => 'Булево',
                        'color'                  => 'Цвет',
                        'copyable'               => 'Копируемое',
                        'copy-message'           => 'Сообщение при копировании',
                        'copy-message-duration'  => 'Длительность сообщения',
                        'default'                => 'По умолчанию',
                        'filterable'             => 'Фильтруемое',
                        'groupable'              => 'Группируемое',
                        'grow'                   => 'Растягивать',
                        'icon'                   => 'Иконка',
                        'icon-color'             => 'Цвет иконки',
                        'icon-position'          => 'Позиция иконки',
                        'label'                  => 'Метка',
                        'limit'                  => 'Лимит',
                        'line-clamp'             => 'Ограничение строк',
                        'money'                  => 'Деньги',
                        'placeholder'            => 'Плейсхолдер',
                        'prefix'                 => 'Префикс',
                        'searchable'             => 'Доступен поиск',
                        'size'                   => 'Размер',
                        'sortable'               => 'Сортируемое',
                        'suffix'                 => 'Суффикс',
                        'toggleable'             => 'Переключаемое',
                        'tooltip'                => 'Подсказка',
                        'vertical-alignment'     => 'Вертикальное выравнивание',
                        'vertically-align-start' => 'Вертикально к началу',
                        'weight'                 => 'Насыщенность',
                        'width'                  => 'Ширина',
                        'words'                  => 'Слова',
                        'wrap-header'            => 'Перенос заголовка',
                        'column-span'            => 'Занимаемые колонки',
                        'helper-text'            => 'Подсказка',
                        'hint'                   => 'Совет',
                        'hint-color'             => 'Цвет совета',
                        'hint-icon'              => 'Иконка совета',
                    ],

                    'datetime' => [
                        'date'              => 'Дата',
                        'date-time'         => 'Дата и время',
                        'date-time-tooltip' => 'Подсказка даты и времени',
                        'since'             => 'Прошло времени',
                    ],

                    'checkbox-list' => [
                        'separator'                => 'Разделитель',
                        'list-with-line-breaks'    => 'Список с переносами',
                        'bulleted'                 => 'С маркерами',
                        'limit-list'               => 'Лимит списка',
                        'expandable-limited-list'  => 'Разворачиваемый ограниченный список',
                    ],

                    'select' => [
                        'separator'                => 'Разделитель',
                        'list-with-line-breaks'    => 'Список с переносами',
                        'bulleted'                 => 'С маркерами',
                        'limit-list'               => 'Лимит списка',
                        'expandable-limited-list'  => 'Разворачиваемый ограниченный список',
                    ],

                    'checkbox' => [
                        'boolean'     => 'Булево',
                        'false-icon'  => 'Иконка "ложь"',
                        'true-icon'   => 'Иконка "истина"',
                        'true-color'  => 'Цвет "истина"',
                        'false-color' => 'Цвет "ложь"',
                    ],

                    'toggle' => [
                        'boolean'     => 'Булево',
                        'false-icon'  => 'Иконка "ложь"',
                        'true-icon'   => 'Иконка "истина"',
                        'true-color'  => 'Цвет "истина"',
                        'false-color' => 'Цвет "ложь"',
                    ],
                ],
            ],

            'settings' => [
                'title' => 'Настройки',

                'fields' => [
                    'type'           => 'Тип',
                    'input-type'     => 'Тип ввода',
                    'is-multiselect' => 'Мультивыбор',
                    'sort-order'     => 'Порядок сортировки',

                    'type-options' => [
                        'text'          => 'Текстовое поле',
                        'textarea'      => 'Многострочный текст',
                        'select'        => 'Выпадающий список',
                        'checkbox'      => 'Флажок',
                        'radio'         => 'Переключатель',
                        'toggle'        => 'Тумблер',
                        'checkbox-list' => 'Список флажков',
                        'datetime'      => 'Выбор даты и времени',
                        'editor'        => 'Форматированный редактор',
                        'markdown'      => 'Markdown-редактор',
                        'color'         => 'Выбор цвета',
                        'star-rating'   => 'Рейтинг звёздами',
                    ],

                    'input-type-options' => [
                        'text'     => 'Текст',
                        'email'    => 'Email',
                        'numeric'  => 'Числовой',
                        'integer'  => 'Целое число',
                        'password' => 'Пароль',
                        'tel'      => 'Телефон',
                        'url'      => 'URL',
                        'color'    => 'Цвет',
                    ],
                ],
            ],

            'resource' => [
                'title' => 'Ресурс',

                'fields' => [
                    'resource' => 'Ресурс',
                ],
            ],
        ],
    ],

    'table' => [
        'columns' => [
            'code'       => 'Код',
            'name'       => 'Название',
            'type'       => 'Тип',
            'resource'   => 'Ресурс',
            'created-at' => 'Создано',
        ],

        'groups' => [
        ],

        'filters' => [
            'type'     => 'Тип',
            'resource' => 'Ресурс',

            'type-options' => [
                'text'          => 'Текстовое поле',
                'textarea'      => 'Многострочный текст',
                'select'        => 'Выпадающий список',
                'checkbox'      => 'Флажок',
                'radio'         => 'Переключатель',
                'toggle'        => 'Тумблер',
                'checkbox-list' => 'Список флажков',
                'datetime'      => 'Выбор даты и времени',
                'editor'        => 'Форматированный редактор',
                'markdown'      => 'Markdown-редактор',
                'color'         => 'Выбор цвета',
                'star-rating'   => 'Рейтинг звёздами',
            ],
        ],

        'actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Поле восстановлено',
                    'body'  => 'Поле успешно восстановлено.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Поле удалено',
                    'body'  => 'Поле успешно удалено.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Поле безвозвратно удалено',
                    'body'  => 'Поле безвозвратно удалено.',
                ],
            ],
        ],

        'bulk-actions' => [
            'restore' => [
                'notification' => [
                    'title' => 'Поля восстановлены',
                    'body'  => 'Поля успешно восстановлены.',
                ],
            ],

            'delete' => [
                'notification' => [
                    'title' => 'Поля удалены',
                    'body'  => 'Поля успешно удалены.',
                ],
            ],

            'force-delete' => [
                'notification' => [
                    'title' => 'Поля безвозвратно удалены',
                    'body'  => 'Поля безвозвратно удалены.',
                ],
            ],
        ],
    ],
];
