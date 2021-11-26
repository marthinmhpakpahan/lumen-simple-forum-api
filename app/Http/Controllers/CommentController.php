<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{

    public function create(Request $request) {
        $response = [
            "error" => true,
            "message" => "Comment gagal dibuat!",
        ];

        $validator = Validator::make($request->all(), [
            'topic_id' => 'required',
            'user_id' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $comment = new Comment();
        $comment->topic_id = $request->topic_id;
        $comment->user_id = $request->user_id;
        $comment->content = $request->content;
        $comment->status = 'active';
        $saved = $comment->save();

        if($saved) {
            $response = [
                "error" => false,
                "message" => "Comment berhasil dibuat!"
            ];
        }
        
        return response()->json($response);
    }

    public function delete($id) {
        $response = [
            "error" => true,
            "message" => "Comment berhasil dihapus!"
        ];

        $comment = Comment::find($id);
        $comment->status = 'deleted';
        $deleted = $comment->save();
        if($deleted) {
            $response = [
                "error" => false,
                "message" => "Comment berhasil dihapus!",
            ];
        }

        return response()->json($response);
    }

    public function index($id) {
        $response = [
            "error" => true,
            "message" => "Comment tidak ditemukan!",
            "data" => []
        ];

        $comments = Comment::with('user')->where('topic_id', $id)->where('status', 'active')->get();

        if($comments) {
            $response = [
                "error" => false,
                "message" => "Comment ditemukan!",
                "data" => $comments,
            ];
        }

        return response()->json($response);
    }
}
