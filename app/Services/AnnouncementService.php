<?php

namespace App\Services;

use App\Models\Announcement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnnouncementService
{


    public function List(array $filters = [])
    {
        $query = Announcement::query();

        return $query->latest()
            ->simplePaginate($filters['per_page'] ?? 10);
    }

    /**
     * Create new announcement (Draft by default)
     */
    public function create(array $data): Announcement
    {
        return DB::transaction(function () use ($data) {

            $imagePath = null;

            if (isset($data['image'])) {
                $imagePath = $data['image']->store(
                    'announcements',
                    'private'
                );
            }

            return Announcement::create([
                'title'        => $data['title'],
                'body'         => $data['body'],
                'image'    => $imagePath,
            ]);
        });
    }

    /**
     * Update announcement
     */
    public function update(Announcement $announcement, array $data): Announcement
    {
        return DB::transaction(function () use ($announcement, $data) {

            $imagePath = $announcement->image;

            if (isset($data['image']) && $data['image']->isValid()) {

                if ($announcement->image) {
                    Storage::disk('private')->delete($announcement->image);
                }

                $imagePath = $data['image']->store(
                    'announcements',
                    'private'
                );
            }

            $announcement->update([
                'title' => $data['title'] ?? $announcement->title,
                'body'  => $data['body'] ?? $announcement->body,
                'image' => $imagePath,
            ]);

            return $announcement->fresh();
        });
    }
    /**
     * Delete announcement
     */
    public function delete(Announcement $announcement): void
    {
        DB::transaction(function () use ($announcement) {
            $announcement->delete();
        });

        if ($announcement->image) {
            unlink(storage_path('app/private/' . $announcement->image));
        }
    }
}
