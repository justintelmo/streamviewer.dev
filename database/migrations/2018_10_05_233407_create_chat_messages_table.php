<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    // 'id', 'channel_id', 'content', 'chat_id'
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->string('id'); // References the unique chat ID. Should be wholly unique on YT's end
            $table->string('chat_id');
            $table->text('content');
            $table->string('channel_id'); // Should be unique to user
            $table->timestamp('published_at');
            $table->string('display_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
