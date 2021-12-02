<?php

namespace App\Http\Controllers;
use App\Topic;
use Illuminate\Http\Request;
use Validator;

class TopicController extends Controller
{

    public function create(Request $request) {
        $response = [
            "error" => true,
            "message" => "Topik gagal dibuat!",
        ];

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $topic = new Topic();
        $topic->user_id = $request->user_id;
        $topic->title = $request->title;
        $topic->content = $request->content;
        $topic->status = 'active';
        $saved = $topic->save();

        if($saved) {
            $response = [
                "error" => false,
                "message" => "Topik berhasil dibuat!"
            ];
        }
        
        return response()->json($response);
    }

    public function update(Request $request) {
        $response = [
            "error" => true,
            "message" => "Topik gagal diubah!",
        ];

        $validator = Validator::make($request->all(), [
            'topic_id' => 'required',
            'user_id' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $topic = Topic::where('id', $request->topic_id)->where('user_id', $request->user_id)->first();
        if(!$topic) {
            $response['message'] = "Topik tidak ditemukan!";
            return response()->json($response);
        }

        $topic->user_id = $request->user_id;
        $topic->title = $request->title;
        $topic->content = $request->content;
        $saved = $topic->save();

        if($saved) {
            $response = [
                "error" => false,
                "message" => "Topik berhasil diubah!",
            ];
        }
        
        return response()->json($response);
    }

    public function show($id) {
        $response = [
            "error" => true,
            "message" => "Topik tidak ditemukan!",
            "data" => []
        ];

        $topic = Topic::with('user')->find($id);
        if($topic) {
            $response = [
                "error" => false,
                "message" => "Topik ditemukan!",
                "data" => $topic
            ];
        }

        return response()->json($response);
    }

    public function delete($id) {
        $response = [
            "error" => true,
            "message" => "Topik berhasil dihapus!"
        ];

        $topic = Topic::find($id);
        $topic->status = 'inactive';
        $deleted = $topic->save();
        if($deleted) {
            $response = [
                "error" => false,
                "message" => "Topik berhasil dihapus!",
            ];
        }

        return response()->json($response);
    }

    public function activate($id) {
        $response = [
            "error" => true,
            "message" => "Topik berhasil diaktifkan!"
        ];

        $topic = Topic::find($id);
        $topic->status = 'active';
        $activated = $topic->save();
        if($activated) {
            $response = [
                "error" => false,
                "message" => "Topik berhasil diaktifkan!",
            ];
        }

        return response()->json($response);
    }

    public function index(Request $request) {
        $response = [
            "error" => true,
            "message" => "Topik tidak ditemukan!",
            "data" => []
        ];

        $status = $request->status ?: 'active';
        $user_id = $request->user_id;

        $topics = Topic::with('user')->withCount('comment')->where('status', $status)->get();
        if($user_id) {
            $topics = Topic::where('user_id', $user_id)->get();
        }

        if($topics) {
            $response = [
                "error" => false,
                "message" => "Topik ditemukan!",
                "data" => $topics,
            ];
        }

        return response()->json($response);
    }
}
