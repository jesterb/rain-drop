<?php

// Script that will confugre the widget

if (!file_exists('config.ini'))
{
  file_put_contents('config.ini', file_get_contents('config.ini.example'));
}
