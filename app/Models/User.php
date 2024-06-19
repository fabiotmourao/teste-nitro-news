<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Permission;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['nome', 'telefone', 'nivel'];

    public function permissions()
    {
        return $this->hasOne(Permission::class, 'user_id');
    }

    public function cadastrar()
    {
        if (empty($this->nome) || empty($this->telefone) || empty($this->permissao->nivel)) {
            $missingFields = [];
            if (empty($this->nome)) {
                $missingFields[] = 'nome';
            }
            if (empty($this->telefone)) {
                $missingFields[] = 'telefone';
            }
            if (empty($this->permissao->nivel)) {
                $missingFields[] = 'nivel';
            }
            throw new \Exception('Campos não preenchidos: ' . implode(', ', $missingFields));
        }
        $this->save();
    }

    public function preencherDados($nome, $telefone, $nivel)
    {
        $this->nome = $nome;
        $this->telefone = $telefone;
        $this->nivel = $nivel;
        $this->save();

        $this->permissions()->create(['nivel' => $nivel, 'user_id' => $this->id]);
    }

    public function formatTelefone()
    {
        $telefone = $this->telefone;

        // Format the telefone as (XX) XXXX-XXXX or (XX) XXXXX-XXXX
        if (strlen($telefone) === 10) {
            return sprintf('(%s) %s-%s', substr($telefone, 0, 2), substr($telefone, 2, 4), substr($telefone, 6));
        } elseif (strlen($telefone) === 11) {
            return sprintf('(%s) %s-%s', substr($telefone, 0, 2), substr($telefone, 2, 5), substr($telefone, 7));
        }

        return $telefone; // Return the original if it doesn't match the expected lengths
    }
}
