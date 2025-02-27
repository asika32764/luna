<?php
/**
 * Global variables
 * --------------------------------------------------------------
 * @var $app       AppContext      Application context.
 * @var $view      ViewModel       The view modal object.
 * @var $uri       SystemUri       System Uri information.
 * @var $chronos   ChronosService  The chronos datetime service.
 * @var $nav       Navigator       Navigator object to build route.
 * @var $asset     AssetService    The Asset manage service.
 * @var $lang      LangService     The language translation service.
 */

declare(strict_types=1);

use Windwalker\Core\Application\AppContext;
use Windwalker\Core\Asset\AssetService;
use Windwalker\Core\Attributes\ViewModel;
use Windwalker\Core\DateTime\ChronosService;
use Windwalker\Core\Language\LangService;
use Windwalker\Core\Router\Navigator;
use Windwalker\Core\Router\SystemUri;

?>

@extends('admin.global.body')

@section('toolbar-buttons')
    @include('edit-toolbar')
@stop

@push('script')
    {{-- Add Script Here --}}
@endpush

@section('content')
    <form name="admin-form" id="admin-form" 
        action="{{ $nav->self() }}" method="POST"
        uni-form-validate='{"scroll": true}'
        enctype="multipart/form-data">

        @include('types.' . $type)

        <div class="d-none">
            @include('@csrf')
        </div>

    </form>
@stop
