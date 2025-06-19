<?php

namespace App\Csp;

use Spatie\Csp\Policies\Policy;

class CustomPolicy extends Policy
{
    public function configure()
    {
        $this->addDirective('default-src', ['\'self\''])
             ->addDirective('script-src', ['\'self\''])
             ->addDirective('style-src', ['\'self\'', 'fonts.bunny.net'])
             ->addDirective('font-src', ['fonts.bunny.net'])
             ->addDirective('img-src', ['\'self\'', 'data:']);
    }
}
