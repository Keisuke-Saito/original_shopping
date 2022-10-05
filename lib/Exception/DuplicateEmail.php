<?php

namespace Shopping\Exception;

class DuplicateEmail extends \Exception {
  protected $message = '既にメールアドレスが登録済みです!';
}