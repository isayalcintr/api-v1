<?php

namespace App\Repositories\Traits;

use App\Enums\Log\ActionEnum;
use App\Repositories\Log\LogRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Logable
{
    private ?LogRepository $logRepository = null;


    /**
     * Log sistemini otomatik başlatır.
     */
    protected function initializeLogable(): void
    {
        $this->logRepository = resolve(LogRepository::class);
    }

    /**
     * AfterCreate Hook - Yeni kayıt oluşturulduğunda log ekler.
     */
    protected function insertLogAfterCreateP1(Model $record): void
    {
        $this->storeLog($record, ActionEnum::INSERT->value);
    }

    /**
     * AfterUpdate Hook - Kayıt güncellendiğinde log ekler.
     */
    protected function insertLogAfterUpdateP1(Model $record): void
    {
        $this->storeLog($record, ActionEnum::UPDATE->value);
    }

    /**
     * AfterDelete Hook - Kayıt silindiğinde log ekler.
     */
    protected function insertLogAfterDeleteP1(Model $record): void
    {
        $this->storeLog($record, ActionEnum::DELETE->value);
    }

    /**
     * AfterUpdateOrCreate Hook - Güncelleme veya ekleme yapıldığında uygun log'u ekler.
     */
    protected function insertLogAfterUpdateOrCreateP1(Model $record): void
    {
        $record->wasRecentlyCreated
            ? $this->insertLogAfterCreateP1($record)
            : $this->insertLogAfterUpdateP1($record);
    }

    /**
     * Log kaydını oluşturur.
     */
    private function storeLog(Model $record, int $action): void
    {
        if (!$this->logRepository) {
            $this->initializeLogable();
        }

        $this->logRepository->create([
            'module' => $this->getModule(),
            'related_id' => $record->id ?? null,
            'action' => $action,
            'user_id' => Auth::id() ?: null,
            'ip' => request()->ip() ?: null,
            'data' => $this->getLogData($record)
        ]);
    }

    /**
     * Loglanacak veriyi belirler.
     * Varsayılan olarak modeli ilişkileriyle birlikte yükler.
     * Alt sınıfta ezilerek farklı veri kaynakları kullanılabilir.
     */
    protected function getLogData(Model $record): Model|array
    {
        return $record->load($this->logRelations());
    }

    /**
     * İlgili modelin bağlı olduğu modülün ID'sini döndürür.
     */
    protected function getModule(): int
    {
        return property_exists($this, 'module') ? $this->module : 0;
    }

    /**
     * Log kaydında hangi ilişkilerin dahil edileceğini belirler.
     */
    protected function logRelations(): array
    {
        return method_exists($this, 'relations') ? $this->relations() : [];
    }
}
