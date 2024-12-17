<?php

namespace hemike1\Browsershot\Enums;

enum Polling: string
{
    case RequestAnimationFrame = 'raf';
    case Mutation = 'mutation';
}
