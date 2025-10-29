<?php

use Livewire\Component;

new class extends Component
{
    public $computerChoice = '';
    public $playerChoice = '';
    public $result = '';

    public function mount()
    {
        $this->computerChoice = $this->getComputerChoice();
    }

    public function getComputerChoice() 
    {
        $choices = ['pedra', 'papel', 'tesoura'];
        return $choices[array_rand($choices)];
    }

    public function play($choice)
    {
        $this->playerChoice = $choice;
        $this->computerChoice = $this->getComputerChoice();
        $this->result = $this->getResult();
    }

    public function getResult()
    {
        if ($this->playerChoice == $this->computerChoice) {
            return 'Empate';
        } elseif (
            ($this->playerChoice == 'pedra' && $this->computerChoice == 'tesoura') ||
            ($this->playerChoice == 'papel' && $this->computerChoice == 'pedra') ||
            ($this->playerChoice == 'tesoura' && $this->computerChoice == 'papel')
        ) {
            return 'Você ganhou!';
        } else {
            return 'Você perdeu!';
        }
    }

    public function render()
    {
        return view('components.⚡jokenpo');
    }
};
?>

<div>
    <button wire:click="play('pedra')">Pedra</button>
    <button wire:click="play('papel')">Papel</button>
    <button wire:click="play('tesoura')">Tesoura</button>

    <p>Você escolheu: {{ $playerChoice }}</p>
    <p>Computador escolheu: {{ $computerChoice }}</p>
    @if ($result == 'Empate')
        <p>O resultado foi {{ $result }}</p>
    @elseif ($result == 'Você ganhou!')
        <p>Parabéns! {{ $result }}!</p>
    @else
        <p>Que pena! {{ $result }}. Tente novamente</p>
    @endif
</div>