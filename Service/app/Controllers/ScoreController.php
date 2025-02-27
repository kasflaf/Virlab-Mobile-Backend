<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class ScoreController extends ResourceController
{
    protected $modelName = "App\Models\UserModel";
    protected $format = "json";

    public function getScore()
    {
        $userId = $this->request->user["id"];

        // Find the user by ID
        $user = $this->model->find($userId);

        if (!$user) {
            return $this->failNotFound("User not found");
        }

        return $this->respond([
            "status" => 200,
            "message" => "User score retrieved successfully",
            "data" => [
                "user_id" => $userId,
                "user_score" => (int) $user["user_score"],
            ],
        ]);
    }

    public function updateScore()
    {
        // Get the JSON input
        $input = $this->request->getJSON();

        // Check if the input is valid JSON
        if (!$input) {
            return $this->failValidationErrors("Invalid JSON input");
        }

        // Retrieve user ID from the request and new score from the JSON input
        $userId = $this->request->user["id"];
        $newScore = $input->user_score ?? null;

        // Validate new score
        if (!is_numeric($newScore)) {
            return $this->failValidationErrors("Invalid score value");
        }

        // Find the user by ID
        $user = $this->model->find($userId);
        if (!$user) {
            return $this->failNotFound("User not found");
        }

        // Prepare the data for updating
        $updateData = [
            "user_score" => (int) $newScore,
        ];

        try {
            // Update the user's score
            if ($this->model->update($userId, $updateData)) {
                return $this->respond([
                    "status" => 200,
                    "message" => "User score updated successfully",
                    "data" => [
                        "user_id" => $userId,
                        "user_score" => $newScore,
                    ],
                ]);
            }

            return $this->fail("Failed to update user score");
        } catch (\Exception $e) {
            log_message(
                "error",
                "Error updating user score: " . $e->getMessage()
            );
            return $this->fail("An error occurred while updating the score");
        }
    }

    public function leaderboard()
    {
        try {
            // Get top 10 users ordered by score
            $topUsers = $this->model
                ->select("username, user_score")
                ->orderBy("user_score", "DESC")
                ->limit(10)
                ->find();

            if (empty($topUsers)) {
                return $this->respond([
                    "status" => 200,
                    "message" => "No users found",
                    "data" => [],
                ]);
            }

            return $this->respond([
                "status" => 200,
                "message" => "Leaderboard retrieved successfully",
                "data" => $topUsers,
            ]);
        } catch (\Exception $e) {
            log_message(
                "error",
                "Error retrieving leaderboard: " . $e->getMessage()
            );
            return $this->fail(
                "An error occurred while retrieving leaderboard"
            );
        }
    }
}
