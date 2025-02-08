<div>
    <x-mary-card>
        <div class="py-12 text-center">
            <div
                class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-100"
            >
                <x-mary-icon name="o-x-circle" class="h-8 w-8 text-red-500" />
            </div>
            <h2 class="mb-2 text-2xl font-semibold text-gray-900">
                Ujian Tidak Ditemukan
            </h2>
            <p class="mb-6 text-gray-500">
                Maaf, ujian yang Anda cari tidak dapat ditemukan atau telah
                dihapus.
            </p>
            <x-mary-button
                wire:click="$dispatch('showDaftarUjian')"
                secondary
                icon="o-arrow-left"
            >
                Kembali ke Daftar Ujian
            </x-mary-button>
        </div>
    </x-mary-card>
</div>
