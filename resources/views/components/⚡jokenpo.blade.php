<?php

use Livewire\Component;

new class extends Component
{
    public $computerChoice = '';
    public $playerChoice = '';
    public $result = '';
    public $playerScore = 0;
    public $computerScore = 0;
    public $draws = 0;
    public $showResult = false;

    public $emojis = [
        'pedra' => '✊',
        'papel' => '✋',
        'tesoura' => '✌️'
    ];

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
        $this->showResult = true;

        // Atualizar pontuação
        if ($this->result == 'Você ganhou!') {
            $this->playerScore++;
        } elseif ($this->result == 'Você perdeu!') {
            $this->computerScore++;
        } else {
            $this->draws++;
        }
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
            return 'Você ganhou!';
        } else {
            return 'Você perdeu!';
        }
    }

    public function newRound()
    {
        $this->playerChoice = '';
        $this->computerChoice = '';
        $this->result = '';
        $this->showResult = false;
    }

    public function resetGame()
    {
        $this->playerChoice = '';
        $this->computerChoice = '';
        $this->result = '';
        $this->playerScore = 0;
        $this->computerScore = 0;
        $this->draws = 0;
        $this->showResult = false;
    }
};
?>

<div class="min-vh-100 bg-primary bg-gradient py-5">
    <style>
        .btn-choice {
            transition: all 0.3s ease;
        }

        .btn-choice:hover {
            transform: scale(1.1);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }

        .btn-choice:active {
            transform: scale(0.95);
        }

        .animate__bounce {
            animation-duration: 2s;
        }
    </style>
    <div class="container">
        <!-- Título -->
        <div class="text-center mb-5 animate__animated animate__fadeInDown">
            <h1 class="display-1 fw-bold text-white mb-3">🎮 Jokenpô</h1>
            <p class="lead text-white fs-3">Pedra, Papel ou Tesoura?</p>
        </div>

        <!-- Placar -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body p-4">
                <div class="row g-3 text-center">
                    <div class="col-md-4">
                        <div class="card bg-success bg-gradient text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h2 class="display-3 fw-bold mb-2">{{ $playerScore }}</h2>
                                <h6 class="text-uppercase fw-bold mb-0">Você</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-secondary bg-gradient text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h2 class="display-3 fw-bold mb-2">{{ $draws }}</h2>
                                <h6 class="text-uppercase fw-bold mb-0">Empates</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger bg-gradient text-white border-0 shadow-sm">
                            <div class="card-body py-4">
                                <h2 class="display-3 fw-bold mb-2">{{ $computerScore }}</h2>
                                <h6 class="text-uppercase fw-bold mb-0">Computador</h6>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                $total = $playerScore + $computerScore + $draws;
                $winRate = $total > 0 ? round(($playerScore / $total) * 100, 1) : 0;
                @endphp

                @if($total > 0)
                <div class="text-center mt-4">
                    <div class="badge bg-info text-dark fs-5 px-4 py-3">
                        📊 Taxa de Vitória: <strong>{{ $winRate }}%</strong>
                        <span class="ms-2">({{ $total }} partidas)</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Área do Jogo -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-body p-5">
                @if($showResult)
                <!-- Resultado da Jogada -->
                <div class="text-center animate__animated animate__zoomIn">
                    <div class="row justify-content-center align-items-center mb-5 g-4">
                        <!-- Jogador -->
                        <div class="col-md-4 text-center">
                            <div class="display-1 mb-3 animate__animated animate__bounce animate__infinite">
                                {{ $emojis[$playerChoice] }}
                            </div>
                            <h4 class="text-uppercase fw-bold text-primary">{{ $playerChoice }}</h4>
                            <p class="text-muted mb-0">Você</p>
                        </div>

                        <!-- VS -->
                        <div class="col-md-2 text-center">
                            <h2 class="display-4 fw-bold text-muted">VS</h2>
                        </div>

                        <!-- Computador -->
                        <div class="col-md-4 text-center">
                            <div class="display-1 mb-3 animate__animated animate__bounce animate__infinite" style="animation-delay: 0.1s;">
                                {{ $emojis[$computerChoice] }}
                            </div>
                            <h4 class="text-uppercase fw-bold text-danger">{{ $computerChoice }}</h4>
                            <p class="text-muted mb-0">Computador</p>
                        </div>
                    </div>

                    <!-- Mensagem do Resultado -->
                    <div class="mb-4">
                        @if($result == 'Você ganhou!')
                        <div class="alert alert-success border-0 shadow-sm py-4" role="alert">
                            <div class="display-4 mb-3">🎉</div>
                            <h2 class="alert-heading fw-bold">VOCÊ GANHOU!</h2>
                            <p class="mb-0 fs-5">{{ ucfirst($playerChoice) }} vence {{ $computerChoice }}!</p>
                        </div>
                        @elseif($result == 'Você perdeu!')
                        <div class="alert alert-danger border-0 shadow-sm py-4" role="alert">
                            <div class="display-4 mb-3">😢</div>
                            <h2 class="alert-heading fw-bold">VOCÊ PERDEU!</h2>
                            <p class="mb-0 fs-5">{{ ucfirst($computerChoice) }} vence {{ $playerChoice }}!</p>
                        </div>
                        @else
                        <div class="alert alert-secondary border-0 shadow-sm py-4" role="alert">
                            <div class="display-4 mb-3">🤝</div>
                            <h2 class="alert-heading fw-bold">EMPATE!</h2>
                            <p class="mb-0 fs-5">Ambos escolheram {{ $playerChoice }}!</p>
                        </div>
                        @endif
                    </div>

                    <button
                        wire:click="newRound"
                        class="btn btn-primary btn-lg px-5 py-3 fw-bold shadow">
                        🔄 Jogar Novamente
                    </button>
                </div>
                @else
                <!-- Escolha sua Jogada -->
                <div class="text-center">
                    <h2 class="display-6 fw-bold text-dark mb-5">Faça sua escolha:</h2>

                    <div class="row g-4">
                        @foreach(['pedra', 'papel', 'tesoura'] as $choice)
                        <div class="col-md-4">
                            <button
                                wire:click="play('{{ $choice }}')"
                                class="btn btn-outline-primary btn-choice w-100 py-5 border-3 shadow-sm">
                                <div class="display-1 mb-3">{{ $emojis[$choice] }}</div>
                                <h4 class="text-uppercase fw-bold mb-0">{{ $choice }}</h4>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Botão Reset -->
        @if($total > 0)
        <div class="text-center">
            <button
                wire:click="resetGame"
                wire:confirm="Tem certeza que deseja resetar o placar?"
                class="btn btn-danger btn-lg px-5 py-3 fw-bold shadow">
                🔄 Resetar Placar
            </button>
        </div>
        @endif
    </div>
</div>