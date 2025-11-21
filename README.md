# 🪨📄✂️ Rock, Paper, Scissors — Livewire 4 Demo Project

This repository is a demo and playground built to explore and test the new features introduced in [Livewire 4]([https://livewire.laravel.com/docs](https://livewire.laravel.com/docs/4.x/quickstart)).

This example project implements a simple **Rock, Paper, Scissors (Jankenpon - じゃんけんぽん)** game using Laravel + Livewire 4.

---

## Goals

This project focuses on experimenting with:

- **Livewire 4 class routing**
  - Components are now mapped through Livewire class in routes.php.
- **New directory structure**
  - Instead of separate files in `/app/Http/Livewire` and `/app/resources/views/Livewire`, components are now organized under `/app/resources/views/components`, using the emoji ⚡ to identify Livewire components.
- **Reactivity improvements**
  - Faster updates and simplified lifecycle handling.
- **Integration with Blade and Bootstrap**
  - Optimizes Blade templates by "code folding" static content, making components render significantly faster.

---

## How It Works

The project simulates a classic *Rock, Paper, Scissors* match:

- The player selects a move.
- The computer randomly chooses one.
- Livewire handles all state updates and DOM rendering in real-time.
- Results, animations, and scoreboards are updated instantly without page reloads.

---

## Installation & Setup

1. **Clone this repository**

```bash
    git clone https://github.com/yourusername/jokenpo-livewire4.git
    cd jokenpo-livewire4
```

2. **Install dependencies**
   
```bash
    composer install
```

3. **Set up your environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Run the development server**

```bash
php artisan serve
```

5. **Open your browser and visit:**

```bash
http://localhost:8000
```

## Project Structure (Livewire 4 Style)

```bash
resources/
└── views/
    └── components/
        └── ⚡jokenpo.blade.php # The component and view unified.
```

> Note: Unlike previous Livewire versions, you no longer need to register components manually or define routes in web.php.
Livewire 4 uses file-based routing, so your component automatically becomes accessible via /game.


## License

This project is open-source under the [MIT License](https://opensource.org/licenses/MIT).

> This repository serves primarily as a learning sandbox for experimenting with Livewire 4 — the game is just a fun way to explore its new features!
