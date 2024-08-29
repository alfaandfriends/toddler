<?php

use App\Mail\AccountCreated;
use App\Mail\MailbookMail;
use Xammie\Mailbook\Facades\Mailbook;

Mailbook::add(MailbookMail::class);
