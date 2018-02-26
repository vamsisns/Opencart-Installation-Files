<?php
//  Live Price / Живая цена (Динамическое обновление цены)
//  Support: support@liveopencart.com / Поддержка: help@liveopencart.ru

// Heading
$_['module_name']         = 'Живая цена (динамическое обновление цены)';
$_['heading_title']       = 'LIVEOPENCART: '.$_['module_name'];
$_['text_edit']           = 'Настройки модуля: '.$_['module_name'];

// Text
$_['text_module']         = 'Модули';
$_['text_success']        = 'Модуль "'.$_['heading_title'].'" успешно обновлен!';
$_['text_content_top']    = 'Верх страницы';
$_['text_content_bottom'] = 'Низ страницы';
$_['text_column_left']    = 'Левая колонка';
$_['text_column_right']   = 'Правая колонка';
$_['text_category_all']   = '-- все категории --';
$_['text_manufacturer_all'] = '-- все производители --';
$_['liveprice_all_customers_groups'] = '-- все группы --';

$_['text_edit_position']  = 'Изменить размещение';

// VALUES
$_['text_value_disabled']               = 'Выключено';
$_['text_value_starting_from_required'] = 'Включено для товаров с обязательными опциями';
$_['text_value_starting_from_all']      = 'Включено для всех товаров';
$_['text_value_show_from_min']          = 'Для минимальных цен';
$_['text_value_show_from_all']          = 'Для всех товаров';

// Entry
$_['entry_layout']        = 'Схема:';
$_['entry_position']      = 'Расположение:';
$_['entry_status']        = 'Статус:';
$_['entry_sort_order']    = 'Порядок сортировки:';
$_['entry_discount_quantity'] = 'Количество для скидок:';
$_['text_discount_quantity_0'] = 'всего по товару';
$_['text_discount_quantity_1'] = 'отдельно для каждой комбинации опций';
$_['text_discount_quantity_2'] = 'отдельно для каждой комбинации связанных опций';
$_['entry_discount_quantity_spec'] = 'Количество для скидок:';
$_['entry_multiplied_price'] = 'Показывать цену умноженной на количество:';
$_['entry_about'] = 'О модуле';
$_['entry_settings'] = 'Настройки';
$_['entry_discounts'] = 'Глобальные скидки';
$_['text_discounts_description'] = 'Глобальные скидки применяются только для товаров у которых нет собственных скидок (когда список скидок товара пуст). Условие категории работает только для товаров напрямую привязанных к выбранной категории.';
$_['entry_specials'] = 'Глобальные акции';
$_['text_specials_description'] = 'Глобальные акции применяются только для товаров у которых нет собственных акций (когда список акций товара пуст). Условие категории работает только для товаров напрямую привязанных к выбранной категории.';
$_['entry_customize_discounts']    = 'Количество для скидок (настройки товаров)';
$_['entry_add_customize_discounts']    = 'Добавить настройку количества для скидки';
$_['entry_ropro_discounts_addition'] 			= 'Применять префиксы цен<br> к скидкам связанных опций:';
$_['text_ropro_discounts_addition_help'] 	= 'Применять префиксы цен указанные для комбинаций связанных опций к скидкам, аналогично тому как эта функция работает для цен товаров (= + -)';
$_['entry_ropro_specials_addition'] 			= 'Применять префиксы цен<br> к акциям связанных опций:';
$_['text_ropro_specials_addition_help'] 	= 'Применять префиксы цен указанные для комбинаций связанных опций к акциям, аналогично тому как эта функция работает для цен товаров (= + -)';


$_['entry_manufacturers_spec'] = 'Производители';
$_['entry_categories_spec'] = 'Категории';
$_['entry_products_spec'] = 'Товары';

$_['entry_percent_discount_to_total'] = 'Применять процентные скидки к цене с опциями';
$_['entry_entry_percent_discount_to_total_help'] = 'Применять процентные скидки к полной цене товара с учетом опций';

$_['entry_percent_special_to_total'] = 'Применять процентные акции к цене с опциями';
$_['entry_entry_percent_special_to_total_help'] = 'Применять процентные акции к полной цене товара с учетом опций';

$_['entry_default_price']      = 'Показывать цены с учетом опций "по умолчанию"';
$_['entry_default_price_help'] = 'Показывать цены в списках товаров (категории, производители, новинки, рекомендации и т.д.) с учетом значений опций "по умолчанию" (требуется модуль "Расширенные опции")';
$_['entry_default_price_mods'] = 'Значения опций "по умолчанию" должны быть указаны с помощью модуля <a href="https://liveopencart.ru/opencart-moduli-shablony/moduli/prochee/rasshirennyie-optsii-2" target="_blank">Расширенные опции</a>.';

$_['entry_starting_from']      = 'Показывать цены "от ..."';
$_['entry_starting_from_help'] = 'Показывать в категориях, модулях и прочих списках товаров минимальную цену с учетом опций "Цена от ..." (учитываются акции, но не скидки от количества)';

$_['entry_show_from']          = 'Показывать цены с префиксом "от"';
$_['entry_show_from_help']     = 'Показывать цены с префиксом "от" в списках товаров (категории, производители, новинки, рекомендации и т.д.)';

$_['entry_discount_like_special']          = 'Показывать скидки в стиле акций';
$_['entry_discount_like_special_help']     = 'Отображать доступную/используемую скидку на странице товара используя оформление акций';

$_['entry_ignore_cart']      = 'Не учитывать корзину';
$_['entry_ignore_cart_help'] = 'Отключить учет количиества товара уже добавленного в корзину при расчете цены на странице товара';

$_['entry_hide_tax']      		= 'Скрывать налог';
$_['entry_hide_tax_help']			= 'Скрывать налог при обновлении цены на странице товара';

$_['entry_calculate_once']      = 'Живая цена: Учитывать однократно';
$_['entry_calculate_once_help'] = 'учитывать цены (вес, баллы) опций однократно, вне зависимости от выбранного количества товара. ';

$_['entry_animation']      			= 'Анимация цены';
$_['entry_animation_help']      = 'Анимация при смене цены (fading), работает не со всеми шаблонами';

$_['text_success'] = 'Настройки обновлены!';
$_['text_update_alert']     = '(доступна новая версия)';

$_['text_relatedoptions_notify'] = 'Должен быть установлен модуль <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/prochee/svyazannyie-optsii-2" target="_blank">Связанные опции</a> или <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/prochee/svyazannyie-optsii-pro-dlya-opencart-2" target="_blank">Связанные опции PRO</a> ';
$_['text_relatedoptions_pro_notify'] = 'Должен быть установлен модуль: <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/prochee/svyazannyie-optsii-pro-dlya-opencart-2" target="_blank">Связанные опции PRO</a>';

$_['module_description']    = 'Модуль предназначен для динамического обновления цены на странице товара в зависимости от количества и выбранных покупателем опций.<br>
Для определения доступной скидки учитывается количество указанное на странице товара в сумме с количеством товара уже добавленным в корзину (опционально).<br>
Расчет изменения цены по отдельным опциям может быть изменен, чтобы опция учитывалась при опеределении цены товара только 1 раз, вне зависимости от указанного количества товара (включатеся флажком на странице реадактирования опции).
<br><br>
<span class="help">Для работы модуля требуется <a href="http://github.com/vqmod/vqmod" target="_blank">vQmod</a> версии 2.6.1 или выше (<a href="http://liveopencart.ru/chto-takoe-vqmod/" target="_blank">что такое vQmod?</a>).</span>';

$_['text_conversation'] = 'Есть вопросы по работе модуля? Требуется интеграция с шаблоном или доработка? Пишите: <b><a href="mailto:help@liveopencart.ru">help@liveopencart.ru</a></b>.';

$_['entry_we_recommend'] = 'Также рекомендуем:';
$_['entry_show_we_recommend'] = 'показать';
$_['text_we_recommend'] = '
<strong>Связанные опции</strong>&nbsp;&nbsp;( <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/prochee/svyazannyie-optsii-2"
target="_blank" title="Связанные опции на liveopencart.ru">liveopencart.ru</a> ::
<a href="http://opencartforum.com/files/file/2421-связанные-опции-для-opencart2/" target="_blank"
title="Связанные опции на opencartforum.com">opencartforum.com</a> )<br>
модуль позволяющий создавать комбинации связанных опций товаров и указывать для каждой комбинации отдельный остаток, цену, модель и т.д.
Полезен для товаров, имеющих взаимозависимые опции, например, цвет и размер у одежды.<br><br>
<strong>Изображения опций PRO</strong>&nbsp;&nbsp;( <a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/vneshniy-vid/izobrajeniya-optsiy-pro-2"
target="_blank" title="Изображения опций PRO на liveopencart.ru">liveopencart.ru</a> ::
<a href="http://opencartforum.com/files/file/2422-изображения-опций-pro-для-opencart2/" target="_blank"
title="Изображения опций PRO на opencartforum.com">opencartforum.com</a> )<br>
модуль позволяющий привязывать изображения к опциям товара (одно или несколько изображений для каждой опции)
и динамически менять видимые изображения на странице товара в зависимости от выбранной покупателем опции<br><br>
';

$_['module_copyright'] = 'Модуль "'.$_['heading_title'].'" это коммерческое дополнение. Не выкладывайте его на сайтах для скачивания и не передавайте его копии другим лицам.<br>
Приобретая модуль, Вы приобретаете право его использования на одном сайте. <br>Если Вы хотите использовать модуль на нескольких сайтах, следует приобрести отдельную копию модуля для каждого сайта.<br>';

$_['module_info'] = '"'.$_['heading_title'].'" Версия %s | Разработка: <a href="http://19th19th.ru" target="_blank">19th19th.ru</a> | Поддержка: opencart@19th19th.ru | ';
$_['module_page'] = '<a href="http://liveopencart.ru/opencart-moduli-shablony/moduli/tsenyi/jivaya-tsena-dinamicheskoe-obnovlenie-tsenyi-2"
target="_blank" title="Динамическое обновление цены - Живая цена на liveopencart.ru">Динамическое обновление цены - Живая цена на liveopencart.ru</a> |
<a href="http://opencartforum.com/files/file/2423-живая-цена-динамическое-обновление-цены-для-opencart2/"
target="_blank" title="Динамическое обновление цены - Живая цена на opencartforum.com">Динамическое обновление цены - Живая цена на opencartforum.com</a>';

// Error
$_['error_permission']    = 'У Вас нет прав для изменения модуля "'.$_['heading_title'].'"!';
