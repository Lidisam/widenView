<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);//视频名称
//            $table->string('playTime',30);//播放时长
//            $table->integer('collections',10);//被收藏数
//            $table->integer('comments',10);//被评论数
//            $table->integer('downloads',10);//被下载数
//            $table->integer('shareTimes',10);//分享数
//            $table->string('interLink',200);//视频链接
//            $table->integer('video_category_id',10);//视频类别索引id
//            $table->string('category',20);//视频类别
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
