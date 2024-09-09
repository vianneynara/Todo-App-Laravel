@extends('template.app')

@section('content')
<div class="flex justify-center items-center h-screen">
    <div class="bg-gray-300 rounded-lg flex flex-col p-10 w-[500px] shadow-centered">
        <div class="flex justify-between">
            <h1>Register Account</h1>
            <a href="/login" class="btn h-fit" style="width:100px">Login</a>
        </div>
        <div class="flex justify-center my-8">
            <form action="/register" method="post">
                <?= csrf_field() ?>
                <table>
                    <tr>
                        <td class="w-[140px]">
                            <label for="username">Username</label>
                        </td>
                        <td><input type="text" id="username" name="username" autocomplete="username" required></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Password</label>
                        </td>
                        <td><input type="password" id="password" name="password" autocomplete="password" required></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="confirm_password">Confirm Password</label>
                        </td>
                        <td><input type="password" id="confirm_password" name="confirm_password" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" class="btn-submit w-full">Register</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
    const password = document.getElementById('password');
    const confirm_password = document.getElementById('confirm_password');

    function validatePassword() {
        if (password.value !== confirm_password.value) {
            confirm_password.setCustomValidity('Passwords do not match');
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>
@endsection