<?php

namespace App\Services\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;

class KkoPolicy extends Basic
{
    public function configure()
    {

        $this
            ->addDirective(Directive::BASE, [
                Keyword::SELF,
            ])
            ->addDirective(Directive::OBJECT,[
                Keyword::SELF,
            ])
            ->addDirective(Directive::CONNECT, Keyword::SELF)
            ->addDirective(Directive::DEFAULT, Keyword::SELF)
            ->addDirective(Directive::FORM_ACTION, Keyword::SELF)
            ->addDirective(Directive::IMG, [
                Keyword::SELF,
                Keyword::UNSAFE_EVAL,
                'localhost:8000',
                'http://localhost:8000',
                'https://kko.vik.hk',
                'http://kko.vik.hk',
                'data:',
            ])
            ->addDirective(Directive::MEDIA, Keyword::SELF)
            ->addDirective(Directive::FONT,[
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'localhost:8000',
                'http://localhost:8000',
                'https://kko.vik.hk',
                'http://kko.vik.hk',
                'https://stackpath.bootstrapcdn.com',
                'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                'http://fonts.googleapis.com',
                'https://fonts.gstatic.com',
                'http://fonts.gstatic.com'
            ])
            ->addDirective(Directive::SCRIPT, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'localhost:8000',
                'http://localhost:8000',
                'https://kko.vik.hk',
                'http://kko.vik.hk',
                'http://localhost:8000/js/jquery-1.7.2.js',
                'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js',
                'https://cdn.jsdelivr.net/npm/chart.js',
                'https://www.gstatic.com/charts/loader.js',
                'https://code.jquery.com/jquery-3.6.0.min.js',
                'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
                'https://www.gstatic.com',
                'https://www.gstatic.com/charts/50/loader.js',
                'https://www.gstatic.com/charts/loader.js',
            ])
            ->addDirective(Directive::STYLE, [
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'localhost:8000',
                'http://localhost:8000',
                'https://kko.vik.hk',
                'http://kko.vik.hk',
                'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
                'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                'https://www.gstatic.com',
                'http://fonts.googleapis.com',
                'https://fonts.gstatic.com',
                'https://daemonite.github.io',
            ])
            ->addDirective(Directive::STYLE_ELEM,[
                Keyword::SELF,
                Keyword::UNSAFE_INLINE,
                'localhost:8000',
                'http://localhost:8000',
                'https://kko.vik.hk',
                'http://kko.vik.hk',
                'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
                'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                'https://www.gstatic.com',
                'http://fonts.googleapis.com',
                'https://fonts.gstatic.com',
                'https://daemonite.github.io',
            ]);

    }
}
