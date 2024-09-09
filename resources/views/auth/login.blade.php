@extends('template.app')

@section('content')
<div class="flex flex-row justify-center items-center h-screen">
    <div class="bg-gray-300 rounded-lg flex flex-col p-10 w-[500px] shadow-centered">
        <div class="flex justify-between">
            <h1>Sign Into Account</h1>
            <a href="/register" class="btn h-fit" style="width:100px">Register</a>
        </div>
        <div class="flex justify-center my-8">
            <form action="/login" method="post">
                <table>
                    <tr>
                        <td class="w-[140px]">
                            <label for="username">Username</label>
                        </td>
                        <td><input type="text" id="username" name="username" required></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Password</label>
                        </td>
                        <td><input type="password" id="password" name="password" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><button type="submit" class="btn-submit w-full">Login</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
@endsection