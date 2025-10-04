<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gate;
use App\Core\View;
use App\Models\Announcement;

class AnnouncementsController
{
    public function index()
    {
        Gate::allow(['admin', 'teacher']);

        $userRole = $_SESSION['user']['role'] ?? '';

        if ($userRole === 'teacher') {
            $announcements = Announcement::getByRole('teacher');
            View::render('teacher/announcements/index', 'teacher', [
                'announcements' => $announcements
            ]);
        } else {
            $announcements = Announcement::all();
            View::render('admin/announcements/index', 'admin', [
                'announcements' => $announcements
            ]);
        }
    }

    public function create()
    {
        Gate::allow(['admin', 'teacher']);

        View::render('admin/announcements/create', 'admin');
    }

    public function store()
    {
        Gate::allow(['admin', 'teacher']);

        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'user_id' => Auth::user()->id,
            'target_role' => $_POST['target_role'] ?? 'all'
        ];

        Announcement::create($data);

        header('Location: /src/plataforma/app/admin/announcements');
        exit;
    }

    public function edit($id)
    {
        Gate::allow(['admin', 'teacher']);

        $announcement = Announcement::find($id);

        View::render('admin/announcements/edit', 'admin', [
            'announcement' => $announcement
        ]);
    }

    public function update($id)
    {
        Gate::allow(['admin', 'teacher']);

        $announcement = Announcement::find($id);

        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'target_role' => $_POST['target_role'] ?? 'all'
        ];

        $announcement->update($data);

        header('Location: /src/plataforma/app/admin/announcements');
        exit;
    }

    public function delete($id)
    {
        Gate::allow(['admin', 'teacher']);

        $announcement = Announcement::find($id);
        $announcement->delete();

        header('Location: /src/plataforma/app/admin/announcements');
        exit;
    }
}
