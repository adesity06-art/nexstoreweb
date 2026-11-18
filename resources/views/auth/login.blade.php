<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXSTORE - Bauhaus</title>
    <!-- Font Geometris Modern (Pengganti Futura) -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bauhaus-red: #E63946;
            --bauhaus-yellow: #F4A261; /* Kuning yang agak earthy */
            --bauhaus-blue: #1D3557;
            --bg-white: #F1FAEE;
            --text-black: #111111;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Jost', sans-serif;
            background-color: var(--bg-white);
            color: var(--text-black);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ORNAMEN GEOMETRIS BAUHAUS */
        .shape-circle {
            position: absolute;
            width: 400px;
            height: 400px;
            background-color: var(--bauhaus-blue);
            border-radius: 50%;
            top: -100px;
            left: -100px;
            z-index: 0;
            opacity: 0.1;
        }

        .shape-triangle {
            position: absolute;
            width: 0;
            height: 0;
            border-left: 200px solid transparent;
            border-right: 200px solid transparent;
            border-bottom: 350px solid var(--bauhaus-red);
            bottom: -100px;
            right: -50px;
            z-index: 0;
            opacity: 0.1;
        }

        .shape-square {
            position: absolute;
            width: 150px;
            height: 150px;
            background-color: var(--bauhaus-yellow);
            top: 20%;
            right: 15%;
            transform: rotate(45deg);
            z-index: 0;
            opacity: 0.2;
        }

        /* KOTAK UTAMA */
        .bauhaus-container {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            max-width: 900px;
            height: 550px;
            background-color: var(--bg-white);
            border: 4px solid var(--text-black);
        }

        /* SISI KIRI (Teks Besar & Geometris) */
        .left-panel {
            flex: 1;
            background-color: var(--bauhaus-yellow);
            border-right: 4px solid var(--text-black);
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        /* Lingkaran Merah di Panel Kiri */
        .left-panel::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background-color: var(--bauhaus-red);
            border-radius: 50%;
            bottom: -50px;
            right: -50px;
        }

        .left-panel h1 {
            font-size: 4rem;
            line-height: 0.9;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: -2px;
            color: var(--text-black);
            position: relative;
            z-index: 1;
        }

        .left-panel p {
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.4;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        /* SISI KANAN (Form) */
        .right-panel {
            flex: 1;
            padding: 60px;
            background-color: var(--bg-white);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h2 {
            font-size: 2rem;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 30px;
            letter-spacing: -1px;
            border-bottom: 4px solid var(--bauhaus-blue);
            display: inline-block;
            padding-bottom: 5px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            color: var(--text-black);
        }

        .form-control {
            width: 100%;
            padding: 15px;
            background-color: transparent;
            border: 3px solid var(--text-black);
            border-radius: 0;
            font-family: 'Jost', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-black);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            background-color: #FFFFFF;
            box-shadow: 6px 6px 0px var(--bauhaus-blue);
            transform: translate(-2px, -2px);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: var(--text-black);
            color: var(--bg-white);
            border: 3px solid var(--text-black);
            font-family: 'Jost', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: var(--bauhaus-red);
            color: var(--text-black);
            box-shadow: 6px 6px 0px var(--text-black);
            transform: translate(-2px, -2px);
        }

        .alert {
            background-color: var(--bauhaus-red);
            color: #FFFFFF;
            border: 3px solid var(--text-black);
            padding: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* RESPONSIF */
        @media (max-width: 850px) {
            .bauhaus-container {
                flex-direction: column;
                height: auto;
            }
            .left-panel {
                border-right: none;
                border-bottom: 4px solid var(--text-black);
                padding: 30px;
            }
            .left-panel h1 { font-size: 3rem; }
            .right-panel { padding: 30px; }
            .shape-circle, .shape-triangle, .shape-square { display: none; }
        }
    </style>
</head>
<body>

    <!-- Ornamen Geometris -->
    <div class="shape-circle"></div>
    <div class="shape-triangle"></div>
    <div class="shape-square"></div>

    <!-- Kotak Utama -->
    <div class="bauhaus-container">
        <!-- Sisi Kiri -->
        <div class="left-panel">
            <h1>NEX<br>STORE</h1>
            <p>Form Follows Function. Manajemen Toko & Inventori.</p>
        </div>

        <!-- Sisi Kanan -->
        <div class="right-panel">
            <h2>Log In</h2>

            @if ($errors->any())
                <div class="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="admin@nexstore.com" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Masuk →</button>
            </form>
        </div>
    </div>

</body>
</html>