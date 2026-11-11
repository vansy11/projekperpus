<x-layout title="Verifikasi anggota">
    <header class="bg-slate-950 pb-20 pt-12 text-white sm:pb-24 sm:pt-16">
        <div class="container-page">
            <p class="text-sm font-medium text-sky-300">Verifikasi keanggotaan</p>
            <h1 class="mt-4 font-serif text-4xl leading-tight tracking-tight sm:text-5xl">Anggota terverifikasi.</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300">Keanggotaan telah disetujui petugas Perpustakaan Universitas Gajayana Malang.</p>
        </div>
    </header>
    <section class="container-page relative -mt-10 pb-12 sm:-mt-12 sm:pb-16">
        <div class="panel mx-auto max-w-xl rounded-xl p-6 shadow-sm sm:p-8">
            <div class="flex items-center gap-3 border-b border-slate-200 pb-5">
                <x-icon name="shield" class="h-6 w-6 text-sky-700"/>
                <h2 class="text-lg font-semibold tracking-tight text-slate-950">Data anggota</h2>
            </div>

            <dl class="mt-2 divide-y divide-slate-100 text-sm">
                @foreach(['Nama' => $anggota->user->nama, 'NIM' => $anggota->nim, 'Program studi' => $anggota->prodi, 'Fakultas' => $anggota->fakultas ?: 'Belum tercatat', 'Tanggal terbit' => $anggota->tanggal_terbit?->format('d/m/Y') ?? 'Belum tercatat'] as $label => $value)
                    <div class="grid grid-cols-[110px_minmax(0,1fr)] gap-4 py-4">
                        <dt class="text-slate-500">{{ $label }}</dt>
                        <dd class="break-words font-medium text-slate-950">{{ $value }}</dd>
                    </div>
                @endforeach
                <div class="grid grid-cols-[110px_minmax(0,1fr)] gap-4 py-4">
                    <dt class="text-slate-500">Status</dt>
                    <dd><x-status :status="$anggota->status_verifikasi"/></dd>
                </div>
            </dl>

            <a href="{{ route('katalog.index') }}" class="btn-secondary mt-6 w-full">Buka katalog buku</a>
        </div>
    </section>
</x-layout>
