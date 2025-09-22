<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class VerifyViewsCommand extends Command
{
    protected $signature = 'mype:verify-views';
    protected $description = 'Verificar que todas las vistas necesarias existen';

    public function handle()
    {
        $this->info('Verificando estructura de vistas...');
        
        $requiredViews = [
            'resources/views/mype/dashboard.blade.php',
            'resources/views/emails/mype-consulta.blade.php',
            'resources/views/welcome.blade.php'
        ];
        
        $allExist = true;
        
        foreach ($requiredViews as $view) {
            if (File::exists($view)) {
                $this->info("✓ {$view} existe");
            } else {
                $this->error("✗ {$view} NO existe");
                $allExist = false;
            }
        }
        
        if ($allExist) {
            $this->info('✓ Todas las vistas están presentes');
            return 0;
        } else {
            $this->error('✗ Faltan algunas vistas');
            return 1;
        }
    }
}
