<?php

namespace Bakgul\ResourceCreator\Services\RequestServices\RegistrationRequestServices;

use Bakgul\Kernel\Helpers\Text;
use Bakgul\Kernel\Tasks\ConvertCase;
use Bakgul\ResourceCreator\Services\RequestService;

class VueViewSectionRegistrationRequestService extends RequestService
{
    public function handle(array $request): array
    {
        return [
            'attr' => array_merge($request['attr'], [
                'target_file' => $this->setTargetFile($request),
            ]),
            'map' => array_merge($request['map'], [
                'imports' => $this->setImport($request),
                'components' => $request['map']['name']
            ])
        ];
    }

    private function setTargetFile(array $request)
    {
        return $request['attr']['path'] . Text::append(Text::getTail($request['attr']['path']) . '.vue');
    }

    private function setImport(array $request): string
    {
        return 'import '
            . ConvertCase::pascal($request['map']['name'])
            . ' from "./'
            . $request['map']['name']
            . '.vue"';
    }
}