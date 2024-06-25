<?php

use App\Http\Controllers\AgrupadorController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\LocalizadorController;
use App\Http\Controllers\MeioPagamentoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecebimentoController;
use App\Http\Controllers\ReceitaController;
use App\Http\Middleware\PeriodoIsOpen;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
})->name('welcome');

Route::get('/dashboard', [PeriodoController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// filtros
Route::middleware('auth')->group(function () {
    Route::get('/filter/receita', [FilterController::class, 'receita'])->name('filter.receita');
    Route::post('/filter/receita', [FilterController::class, 'receita'])->name('filter.receita');
    Route::get('/filter/despesa', [FilterController::class, 'despesa'])->name('filter.despesa');
    Route::post('/filter/despesa', [FilterController::class, 'despesa'])->name('filter.despesa');
    Route::get('/filter/gasto', [FilterController::class, 'gasto'])->name('filter.gasto');
    Route::post('/filter/gasto', [FilterController::class, 'gasto'])->name('filter.gasto');
    Route::post('/filter/gasto/payment', [FilterController::class, 'payment'])->name('filter.gasto.payment');
    Route::post('/filter/gasto/pay', [FilterController::class, 'pay'])->name('filter.gasto.pay');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// período
// Não mudar ordem das rotas, caso contrário bugs acontecerão
Route::middleware('auth')->group(function () {
    Route::get('/periodo/reconcile', [PeriodoController::class, 'reconcile'])->name('periodo.reconcile');
    Route::post('/periodo/reconcile/adjust', [PeriodoController::class, 'reconcileAdjust'])->name('periodo.reconcile.adjust')->middleware(PeriodoIsOpen::class);
    Route::get('/periodo/manage', [PeriodoController::class, 'manage'])->name('periodo.manage');
    Route::get('/periodo/{periodo}/close', [PeriodoController::class, 'close'])->name('periodo.close')->middleware(PeriodoIsOpen::class);
    Route::get('/periodo/{periodo}/open', [PeriodoController::class, 'open'])->name('periodo.open');
    Route::get('/periodo/next', [PeriodoController::class, 'next'])->name('periodo.next');
    Route::get('/periodo/previous', [PeriodoController::class, 'previous'])->name('periodo.previous');
    Route::get('/periodo/{periodo?}', [PeriodoController::class, 'select'])->name('periodo.go');
    Route::post('/periodo', [PeriodoController::class, 'select'])->name('periodo.select');
});

// receita
Route::middleware('auth')->group(function () {
    Route::get('/receita/create', [ReceitaController::class, 'create'])->name('receita.create');
    Route::post('/receita/store', [ReceitaController::class, 'store'])->name('receita.store')->middleware(PeriodoIsOpen::class);
    Route::get('/receita/{receita_id}/show', [ReceitaController::class, 'show'])->name('receita.show');
    Route::get('/receita/{receita_id}/edit', [ReceitaController::class, 'edit'])->name('receita.edit')->middleware(PeriodoIsOpen::class);
    Route::put('/receita/update', [ReceitaController::class, 'update'])->name('receita.update')->middleware(PeriodoIsOpen::class);
    Route::get('/receita/{receita_id}/delete', [ReceitaController::class, 'destroy'])->name('receita.delete')->middleware(PeriodoIsOpen::class);
    Route::get('/receita/repeat', [ReceitaController::class, 'repeat'])->name('receita.repeat');
    Route::post('/receita/repeat/confirm', [ReceitaController::class, 'repeatConfirm'])->name('receita.repeat.confirm');
    Route::post('/receita/repeat/store', [ReceitaController::class, 'repeatStore'])->name('receita.repeat.store');
    Route::get('/receita/parcel', [ReceitaController::class, 'parcel'])->name('receita.parcel');
    Route::post('/receita/parcel/confirm', [ReceitaController::class, 'parcelConfirm'])->name('receita.parcel.confirm');
    Route::post('/receita/parcel/store', [ReceitaController::class, 'parcelStore'])->name('receita.parcel.store');
    Route::get('/receita/{receita_id}/previsao/adjust', [ReceitaController::class, 'adjustPrevisao'])->name('receita.previsao.adjust')->middleware(PeriodoIsOpen::class);
});

// recebimento
Route::middleware('auth')->group(function () {
    Route::get('/receita/{receita_id}/recebimento/create', [RecebimentoController::class, 'create'])->name('recebimento.create')->middleware(PeriodoIsOpen::class);
    Route::post('/receita/{receita_id}/recebimento/store', [RecebimentoController::class, 'store'])->name('recebimento.store')->middleware(PeriodoIsOpen::class);
    Route::get('/receita/{receita_id}/recebimento/{recebimento_id}/edit', [RecebimentoController::class, 'edit'])->name('recebimento.edit')->middleware(PeriodoIsOpen::class);
    Route::put('/receita/{receita_id}/recebimento/update', [RecebimentoController::class, 'update'])->name('recebimento.update')->middleware(PeriodoIsOpen::class);
    Route::get('/receita/{receita_id}/recebimento/{recebimento_id}/delete', [RecebimentoController::class, 'destroy'])->name('recebimento.delete')->middleware(PeriodoIsOpen::class);
});

// despesa
Route::middleware('auth')->group(function () {
    Route::get('/despesa/create', [DespesaController::class, 'create'])->name('despesa.create');
    Route::post('/despesa/store', [DespesaController::class, 'store'])->name('despesa.store')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/{despesa_id}/show', [DespesaController::class, 'show'])->name('despesa.show');
    Route::get('/despesa/{despesa_id}/edit', [DespesaController::class, 'edit'])->name('despesa.edit')->middleware(PeriodoIsOpen::class);
    Route::put('/despesa/update', [DespesaController::class, 'update'])->name('despesa.update')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/{despesa_id}/delete', [DespesaController::class, 'destroy'])->name('despesa.delete')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/repeat', [DespesaController::class, 'repeat'])->name('despesa.repeat');
    Route::post('/despesa/repeat/confirm', [DespesaController::class, 'repeatConfirm'])->name('despesa.repeat.confirm');
    Route::post('/despesa/repeat/store', [DespesaController::class, 'repeatStore'])->name('despesa.repeat.store');
    Route::get('/despesa/parcel', [DespesaController::class, 'parcel'])->name('despesa.parcel');
    Route::post('/despesa/parcel/confirm', [DespesaController::class, 'parcelConfirm'])->name('despesa.parcel.confirm');
    Route::post('/despesa/parcel/store', [DespesaController::class, 'parcelStore'])->name('despesa.parcel.store');
    Route::get('/despesa/{despesa_id}/previsao/adjust', [DespesaController::class, 'adjustPrevisao'])->name('despesa.previsao.adjust')->middleware(PeriodoIsOpen::class);
});

// gasto
Route::middleware('auth')->group(function () {
    Route::get('/despesa/{despesa_id}/gasto/create', [GastoController::class, 'create'])->name('gasto.create')->middleware(PeriodoIsOpen::class);
    Route::post('/despesa/{despesa_id}/gasto/store', [GastoController::class, 'store'])->name('gasto.store')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/{despesa_id}/gasto/{gasto_id}/edit', [GastoController::class, 'edit'])->name('gasto.edit')->middleware(PeriodoIsOpen::class);
    Route::put('/despesa/{despesa_id}/gasto/update', [GastoController::class, 'update'])->name('gasto.update')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/{despesa_id}/gasto/{gasto_id}/delete', [GastoController::class, 'destroy'])->name('gasto.delete')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/{despesa_id}/gasto/{gasto_id}/payment', [GastoController::class, 'payment'])->name('gasto.payment')->middleware(PeriodoIsOpen::class);
    Route::put('/despesa/{despesa_id}/gasto/pay', [GastoController::class, 'pay'])->name('gasto.pay')->middleware(PeriodoIsOpen::class);
    Route::get('/despesa/{despesa_id}/gasto/{gasto_id}/transpose/{periodo?}', [GastoController::class, 'transpose'])->name('gasto.transpose')->middleware(PeriodoIsOpen::class);
    Route::put('/despesa/gasto/transpose', [GastoController::class, 'transposeStore'])->name('gasto.transpose.store')->middleware(PeriodoIsOpen::class);
});

// pessoa
Route::middleware('auth')->group(function () {
    Route::get('/pessoa/list', [PessoaController::class, 'list'])->name('pessoa.list');
    Route::get('/pessoa/{pessoa}/show', [PessoaController::class, 'show'])->name('pessoa.show');
});

// agrupador
Route::middleware('auth')->group(function () {
    Route::get('/agrupador/list', [AgrupadorController::class, 'list'])->name('agrupador.list');
    Route::get('/agrupador/{agrupador}/show', [AgrupadorController::class, 'show'])->name('agrupador.show');
});

// localizador
Route::middleware('auth')->group(function () {
    Route::get('/localizador/list', [LocalizadorController::class, 'list'])->name('localizador.list');
    Route::get('/localizador/{localizador}/show', [LocalizadorController::class, 'show'])->name('localizador.show');
});

// meio de pagamento
Route::middleware('auth')->group(function () {
    Route::get('/mp/list', [MeioPagamentoController::class, 'list'])->name('mp.list');
    Route::get('/mp/{mp}/show', [MeioPagamentoController::class, 'show'])->name('mp.show');
});


require __DIR__.'/auth.php';
