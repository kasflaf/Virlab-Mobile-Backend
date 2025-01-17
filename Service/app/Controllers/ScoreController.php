<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class ScoreController extends ResourceController
{
    protected $modelName = "App\Models\UserModel";
    protected $format = "json";

    // Method to get the score of a user by their ID
    public function getScore()
    {
        $user = $this->request->user["id"];

        if (!$user) {
            return $this->failNotFound("User not found");
        }

        return $this->respond([
            "status" => 200,
            "message" => "User score retrieved successfully",
            "data" => [
                "user_id" => $user["id"],
                "user_score" => $user["user_score"],
            ],
        ]);
    }

    // Method to update the score of a user by their ID
    // Method to update the score of a user by their ID
    public function updateScore()
    {
        // Get the JSON input
        $input = $this->request->getJSON();

        // Check if the input is valid JSON
        if (!$input) {
            return $this->failValidationError("Invalid JSON input");
        }

        // Retrieve user ID and new score from the JSON input
        $userId = $this->request->user["id"] ?? null;
        $newScore = $input->user_score ?? null;

        // Validate user ID and new score
        if (is_null($userId) || !is_numeric($newScore)) {
            return $this->failValidationError("Invalid user ID or score value");
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
        } else {
            return $this->fail("Failed to update user score");
        }
    }
}
