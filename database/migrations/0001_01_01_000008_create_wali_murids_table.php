<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wali_murids', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('nama', 60);
            $table->string('phone')->unique();
            $table->text('alamat');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Protestan', 'Budha', 'Hindu']);
            $table->enum('pendidikan', ['S3', 'S2', 'S1', 'SMA', 'SMP', 'SD']);
            $table->enum('pekerjaan', [
                'Wiraswasta', 'Pegawai Swasta', 'Pegawai BUMN', 'ASN', 'TNI', 'POLRI',
                'Guru', 'Dosen', 'Ibu Rumah Tangga', 'Pedagang', 'Freelancer', 'Tidak Bekerja'
            ]);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wali_murids');
    }
};
