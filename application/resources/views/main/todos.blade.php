<?php

use Illuminate\Support\Facades\Session;
?>
@extends('template.app')

@section('content')
<div class="bg-gray-100 mx-auto w-[500px] p-2 h-screen flex flex-col">
    <header class="bg-gray-200 mb-2 p-2 rounded">
        <nav class="flex justify-between items-center">
            <a href="/logout" class="btn flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
                <span style="font-weight:bold; margin-right:3px;">Log out</span>
            </a>
            <a href="/todos">
                <h1 class="font-extrabold">Todo App</h1>
            </a>
            <button class="btn" onclick="openCreateTodoDialog()"><span style="font-weight:bold;">New Todo</span></button>
        </nav>
    </header>
    <main class="bg-gray-200 flex-grow mb-10 p-2 rounded">
        <div class="wrap text-center">
            <div class="flex justify-between mb-2">
                <span class="font-bold">List of Todos (<?= Session::get('username') ?>)</span>
                <a class="btn" href="/todos">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </a>
            </div>
        </div>
        <!-- create a line  -->
        <hr style="height:2px; color:black; background-color:black;">
        <?php if (empty($todos)) : ?>
            <div class="text-center">
                No todos found.
            </div>
        <?php else : ?>
            <table id="todos-table" class="w-full rounded-b-md">
                <thead>
                    <tr>
                        <th style="width:5%">Id</th>
                        <th style="width:100%">Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <hr>
                <tbody>
                    <?php foreach ($todos as $todo) : ?>
                        <?php
                        $currTodoId = $todo['todo_id'];
                        ?>
                        <tr id="todo-item-<?= $currTodoId ?>" class="odd:bg-gray-300 even:bg-gray-200">
                            <td style="font-weight:bold"><?= $currTodoId ?></td>
                            <td>
                                <input type="text" id="todo-<?= $currTodoId ?>-description" value="<?= $todo['description'] ?>" style="height:28px;" class="w-full px-2 rounded" disabled>
                            </td>
                            <td class="flex justify-between">
                            <td class="flex justify-between gap-1">
                                <button class="btn" onclick="openEditDialogTitle(<?= $currTodoId ?>)">✏️</button>
                                <form action="/todos/toggle" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}">
                                    <input type="hidden" name="todo_id" value="{{ $currTodoId }}">
                                    <button type="submit" class="btn">
                                        <?= $todo['is_completed'] == false ? '🔲' : '✔️' ?>
                                    </button>
                                </form>
                                <form action="/todos/delete" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ Session::get('user_id') }}">
                                    <input type="hidden" name="todo_id" value="{{ $currTodoId }}">
                                    <button type="submit" class="btn-close">
                                        ❌
                                    </button>
                                </form>
                            </td>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
    <footer class="bg-gray-200 mt-[-2rem] rounded text-center">
        <p>2024 Nara@Laravel</p>
    </footer>
</div>

<dialog id="new-todo-dialog" class="bg-white p-2 rounded-lg fixed inset-0 z-10 w-[450px]">
    <div class="text-center mb-2">
        Create a new todo
    </div>
    <form action="/todos" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="<?= Session::get('user_id') ?>">
        <input type="text" name="description" placeholder="Enter todo description" class="w-full p-2 mb-2 rounded border-solid border-2 border-black" required>
        <div class="flex justify-between gap-1">
            <button type="button" class="btn-close w-16" onclick="document.getElementById('new-todo-dialog').close()">Close</button>
            <button type="submit" class="btn-submit flex-grow">Create</button>
        </div>
    </form>
</dialog>

<dialog id="edit-todo-dialog" class="bg-white p-2 rounded-lg fixed inset-0 z-10 w-[450px]">
    <div class="text-center mb-2">
        Enter new todo title
    </div>
    <form action="/todos/id/description" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="<?= Session::get('user_id') ?>">
        <input type="text" name="description" placeholder="Enter todo description" class="w-full p-2 mb-2 rounded border-solid border-2 border-black">
        <div class="flex justify-between gap-1">
            <button type="button" class="btn-close w-16" onclick="document.getElementById('edit-todo-dialog').close()">Close</button>
            <button type="submit" class="btn-submit flex-grow">Save</button>
        </div>
    </form>
</dialog>

<script>
    // listener to close dialog when clicked outside the dialog bounds
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', function(e) {
            if (e.target.tagName !== 'DIALOG')
                return;

            const rect = e.target.getBoundingClientRect();
            const clickedInDialog = (
                rect.top <= e.clientY &&
                e.clientY <= rect.top + rect.height &&
                rect.left <= e.clientX &&
                e.clientX <= rect.left + rect.width
            );

            if (clickedInDialog === false)
                e.target.close();
        });
    });

    // THIS IS TO HANDLE FORM SUBMISSIONS VIA AJAX
    window.addEventListener('DOMContentLoaded', function() {
        const todoForms = document.querySelectorAll('form[action^="/todos"]');
        todoForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this); // type: FormData
                const url = this.action;

                fetch(
                        url, {
                            method: 'POST',
                            body: formData
                        }
                    )
                    .then(response => console.log('response:', response.json())) // Parse JSON response
                    .then(data => {
                        // Handle successful response
                        if (data.status === 201) {
                            window.location.reload();
                        }
                        // Handle error response
                        else if (data.status === 400) {
                            alert('An error occurred: ' + data.message);
                        } else {
                            console.error('What the fuck:', data.status);
                        }
                    })
                    // WHAT THE FUCK HAPPENED HERE?
                    .catch(error => { // Handle network errors
                        window.location.reload();
                    });
            });
        });
    });

    function openEditDialogTitle(id) {
        document.querySelector('#edit-todo-dialog form').action = `/todos/${id}/title`;
        const oldTitle = document.getElementById(`todo-${id}-title`).value;
        document.querySelector('#edit-todo-dialog input[name="title"]').value = oldTitle;
        document.getElementById('edit-todo-dialog').showModal();
    }

    function openCreateTodoDialog() {
        document.getElementById('new-todo-dialog').showModal();
    }
</script>
@endsection