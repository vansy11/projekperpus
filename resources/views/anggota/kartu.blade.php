<x-layout title="Kartu anggota">
    <header class="no-print bg-slate-950 pb-20 pt-12 text-white sm:pb-24 sm:pt-16">
        <div class="container-page">
            <p class="text-sm font-medium text-sky-300">Keanggotaan perpustakaan</p>
            <h1 class="mt-4 font-serif text-4xl leading-tight tracking-tight sm:text-5xl">Kartu anggota saya.</h1>
            <p class="mt-4 max-w-xl text-sm leading-7 text-slate-300">Lihat status pendaftaran dan kartu anggota Anda di sini.</p>
        </div>
    </header>
    <section class="container-page print-wrapper relative -mt-10 pb-12 sm:-mt-12 sm:pb-16">
        <div class="mx-auto max-w-3xl">

            @if($anggota && $anggota->status_verifikasi === 'disetujui')
                <div class="no-print mb-5 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                    <x-status status="disetujui"/>
                    <button type="button" class="btn-primary" data-print>
                        <x-icon name="print" class="h-4 w-4"/>
                        Cetak kartu
                    </button>
                </div>

                <article class="membership-card overflow-hidden rounded-xl border border-slate-200 border-t-4 border-t-sky-300 bg-white shadow-sm">
                    <div class="flex items-center gap-4 border-b border-slate-200 px-6 py-5 sm:px-8">
                        <x-brand-mark class="h-10 w-10 shrink-0"/>
                        <div>
                            <p class="text-xs font-medium text-slate-500">Kartu anggota perpustakaan</p>
                            <h2 class="mt-1 text-base font-semibold text-slate-950">Universitas Gajayana Malang</h2>
                        </div>
                    </div>
                    <div class="flex flex-col gap-6 p-6 sm:flex-row sm:p-8">
                        <img src="{{ Storage::disk('public')->url($anggota->foto_stnghBadan) }}" alt="Foto {{ $anggota->user->nama }}" width="112" height="144" class="h-36 w-28 shrink-0 rounded border border-slate-200 bg-slate-50 object-cover">
                        <div class="min-w-0 flex-1">
                            <h3 class="break-words text-xl font-semibold text-slate-950">{{ $anggota->user->nama }}</h3>
                            <dl class="mt-4 space-y-3 text-sm">
                                <div class="flex gap-3"><dt class="w-16 shrink-0 text-slate-500">NIM</dt><dd class="break-all font-medium">{{ $anggota->nim }}</dd></div>
                                <div class="flex gap-3"><dt class="w-20 shrink-0 text-slate-500">Prodi</dt><dd class="break-words">{{ $anggota->prodi }}</dd></div>
                                <div class="flex gap-3"><dt class="w-20 shrink-0 text-slate-500">Fakultas</dt><dd class="break-words">{{ $anggota->fakultas ?: 'Belum tercatat' }}</dd></div>
                                <div class="flex gap-3"><dt class="w-24 shrink-0 text-slate-500">Tanggal terbit</dt><dd class="tabular-nums">{{ $anggota->tanggal_terbit?->format('d/m/Y') ?? 'Belum tercatat' }}</dd></div>
                            </dl>
                        </div>
                        <div class="member-qr flex shrink-0 flex-col items-start justify-center sm:items-center">
                            <a href="{{ $verificationUrl }}" aria-label="Verifikasi keanggotaan" class="block rounded border border-slate-200 bg-white p-2">{!! $qrCode !!}</a>
                            <p class="mt-2 text-xs text-slate-500">Verifikasi keanggotaan</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-end border-t border-slate-200 px-6 py-5 text-center sm:px-8">
                        <div class="w-48">
                            <p class="text-xs text-slate-600">Pengesahan</p>
                            <p class="mt-1 text-sm font-medium">{{ config('membership.authority_title', 'Kepala Perpustakaan') }}</p>
                            @if(file_exists(public_path('pengesahan/tanda-tangan.png')) || file_exists(public_path('pengesahan/stempel.png')))
                                <div class="relative mx-auto mt-2 flex h-20 w-40 items-center justify-center">
                                    @if(file_exists(public_path('pengesahan/tanda-tangan.png')))<img src="{{ asset('pengesahan/tanda-tangan.png') }}" alt="Tanda tangan pejabat berwenang" class="relative z-10 max-h-16 max-w-32 object-contain">@endif
                                    @if(file_exists(public_path('pengesahan/stempel.png')))<img src="{{ asset('pengesahan/stempel.png') }}" alt="Stempel perpustakaan" class="absolute right-0 top-0 max-h-20 max-w-20 object-contain">@endif
                                </div>
                            @else
                                <p class="my-5 text-xs text-slate-500">Tanda tangan dan stempel belum tersedia</p>
                            @endif
                            <p class="border-t border-slate-300 pt-2 text-sm">{{ config('membership.authority_name') ?: 'Nama pejabat belum dicantumkan' }}</p>
                        </div>
                    </div>
                </article>
                <p class="no-print mt-5 text-sm leading-6 text-slate-500">Pilih Cetak kartu untuk mencetak atau menyimpan sebagai PDF melalui browser.</p>
            @elseif($anggota && $anggota->status_verifikasi === 'ditolak')
                <section class="panel rounded-xl p-6 shadow-sm sm:p-8">
                    <x-status status="ditolak"/>
                    <h2 class="mt-5 text-xl font-semibold text-slate-950">Pendaftaran belum disetujui</h2>
                    <div class="mt-5 rounded-lg border border-red-200 bg-red-50 p-5">
                        <h3 class="text-sm font-semibold text-red-800">Alasan penolakan</h3>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 text-red-900">{{ $anggota->alasan_penolakan }}</p>
                    </div>
                    <p class="mt-5 text-sm leading-6 text-slate-600">Hubungi petugas perpustakaan untuk memeriksa data pendaftaran Anda.</p>
                    <a href="{{ route('katalog.index') }}" class="btn-secondary mt-6">Lihat katalog</a>
                </section>
            @else
                <section class="panel rounded-xl p-6 shadow-sm sm:p-8">
                    @if($anggota)<x-status :status="$anggota->status_verifikasi"/>@endif
                    <h2 class="mt-5 text-xl font-semibold text-slate-950">{{ $anggota ? 'Pendaftaran sedang diperiksa' : 'Data anggota belum tersedia' }}</h2>
                    <p class="mt-3 max-w-lg text-sm leading-7 text-slate-600">{{ $anggota ? 'Petugas sedang memeriksa data dan berkas Anda. Hasil verifikasi akan dikirim melalui email.' : 'Hubungi petugas perpustakaan untuk memeriksa data keanggotaan Anda.' }}</p>
                    @if($anggota)
                        <p class="mt-5 border-t border-slate-200 pt-5 text-sm text-slate-500">Kartu dan QR tersedia setelah pendaftaran disetujui.</p>
                    @endif
                    <a href="{{ route('katalog.index') }}" class="btn-secondary mt-6">Lihat katalog</a>
                </section>
            @endif
        </div>
    </section>
</x-layout>
