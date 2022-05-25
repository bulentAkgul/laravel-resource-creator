<?php

namespace Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices;

use Bakgul\FileContent\Functions\CreateFile;
use Bakgul\Kernel\Helpers\Prevented;
use Bakgul\Kernel\Helpers\Settings;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueRoutePageRegistrationService;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueRouteSectionRegistrationService;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueStorePageRegistrationService;
use Bakgul\ResourceCreator\Services\RegistrationServices\VueRegistrationServices\VueStoreSectionRegistrationService;
use Bakgul\ResourceCreator\Services\RequestServices\JsRequestServices\VueJsRequestService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices\RootVueJsResourceService;
use Bakgul\ResourceCreator\Services\ResourceServices\JsResourceServices\JsResourceSubServices\ClientVueJsResourceService;

class VueJsResourceService extends JsResourceService
{
    public function create(array $request): void
    {
        match ($request['attr']['variation']) {
            'root' => $this->createRoot($request),
            'client' => $this->createClient($request),
            default => $this->createFiles($request)
        };
    }

    private function createRoot($request)
    {
        (new RootVueJsResourceService)->create(
            (new VueJsRequestService('root'))->handle($request)
        );
    }

    private static function createClient($request)
    {
        (new ClientVueJsResourceService)->create(
            (new VueJsRequestService($request['attr']['role']))->handle($request)
        );
    }

    private function createFiles($request)
    {
        foreach (['store', 'route'] as $role) {
            if ($this->isNotRequired($role, $request)) continue;

            $newRequest = (new VueJsRequestService($role))->handle($request);

            CreateFile::_($newRequest);

            $this->registrationService($newRequest['attr'], $role)?->handle($newRequest);
        }
    }

    private function isNotRequired($role, $request): bool
    {
        if ($role == 'store') return $this->isNotStorable($request['attr']);
        if ($role == 'route') return $this->isNotRoutable($request['attr']);

        return true;
    }

    private function isNotStorable($attr)
    {
        return Prevented::store($attr['pipeline']['type'])
            || in_array($attr['variation'], Settings::get('levels.low'));
    }

    private function isNotRoutable($attr)
    {
        return Prevented::route($attr['router'], $attr['type'])
            || !in_array($attr['variation'], Settings::get('levels.high'));
    }

    private function registrationService($attr, $role): ?object
    {
        return match (true) {
            $role == 'store' && $attr['variation'] == 'page' => new VueStorePageRegistrationService,
            $role == 'store' && $attr['variation'] == 'section' => new VueStoreSectionRegistrationService,
            $role == 'route' && $attr['variation'] == 'page' => new VueRoutePageRegistrationService,
            $role == 'route' && $attr['variation'] == 'section' => new VueRouteSectionRegistrationService,
            default => null
        };
    }
}
