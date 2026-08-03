<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Armindo Perkasa-{{ isset($title) ? $title : '' }}</title>
<!-- fav icon -->
@if(isset($logo2))
    <link rel="shortcut icon" href="/img/icon/logohino2.png">
@elseif (isset($logo1))
    <link rel="shortcut icon" href="/img/icon/logohino2.png">
@elseif (isset($logo4))
    <link rel="shortcut icon" href="/img/icon/logohino2.png">
@else
   <link rel="shortcut icon" href="/img/icon/logohino2.png">
@endif
