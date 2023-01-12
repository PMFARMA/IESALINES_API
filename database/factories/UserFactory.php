<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string,
     * mixed>
     */
    public function definition()
    {
        return [
            'email' => $this->faker->freeEmail(),
            'passwd' => password_old('12341234'),
            'idDeleg' => NULL,
            'nombre' => $this->faker->name(),
            'apellidos' => $this->faker->name(),
            'cargo' => $this->faker->jobTitle(),
            'movil' => $this->faker->phoneNumber(),
            'recibirSemanal' => 'H',
            'recibe_revista' => 0,
            'recibe_donde' => 'E',
            'susc' => 'N',
            'fechaAlta' => date('Y-m-d H:i:s'),
            'posicion' => NULL,
            'anuario' => 'N',
            '1persona' => 0,
            'aviso_legal' => date('Y-m-d H:i:s'),
            'linkedin_id' => NULL,
            'linkedin_token' => NULL,
            'linkedin_token_secret' => NULL,
            'linkedin_dp' => NULL,
            'linkedin_fecha_sync' => NULL,
            'fechaUltimAcceso' => date('Y-m-d H:i:s'),
            'ciudad' => NULL,
            'carta_ptn' => NULL,
            'fecha_nac' => $this->faker->dateTime('1980-01-01'),
            'verifEmail' => 1,
            'disp_viajar' => NULL,
            'laboral' => 1,
            'permiso_c' => NULL,
            'prv_residencia' => 654,
            'alertas_mail' => NULL,
            'alertas_periodo' => 'D',
            'sexo' => NULL,
            'tel' => $this->faker->phoneNumber(),
            'privacidad' => 'N',
            'candidato_activo' => 'N',
            'fechaActCv' => $this->faker->date(),
            'vistas' => NULL,
            'ultimo_cv_selec' => NULL,
            'fechaRenewPasswd' => NULL,
            'o_empresa' => NULL,
            'pdf' => 'S',
            'radiografia' => NULL,
            'alertas_videos' => NULL,
            'pais_id' => 28,
            'estado_id' => 654,
            'tipoEmpresa' => NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'visitador' => NULL
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
