<?php

namespace App\Enums;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum PidumAktivitisStatus: String
{
    use IsKanbanStatus;
    case Belum = 'Belum';
    case Proses = 'Proses';
    case Revisi = 'Revisi';
    case Selesai = 'Selesai';
}
