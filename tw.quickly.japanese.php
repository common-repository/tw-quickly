<?php
/*
Plugin Name:Tw Quickly(日本語版)
Plugin URI:https://hanauta-apron.com/diary/tw-quickly/
Description:記事編集画面からその記事をワンクリックでツイートできるプラグインです。編集画面内のリンクをクリックすることで、タイトル＋URLの文章が表示されます。ハッシュタグの追加など、自由にツイートが編集できるのが魅力です。
Version:1.0
Author:kaeru
Author URI:https://diary.hanauta-apron.com/
License:CC BY-NC-SA 4.0
*/

////////////////////////////////////////////////////////////////////
// 特権管理者、管理者、編集者、投稿者の何れでもない場合は無視
//カスタムフィールドの見た目（入力欄等）を追加する
function hook_func_for_metabox_tw_quick(){
    // ① メタボックスの特性を定義する
    add_meta_box( 
        'metabox_div_id',//メタボックスのdivに指定されるID
        'Tw Quickly(日本語版)', //タイトル
        'html_for_metabox_tw_quick_func', //表示用のHTMLを出力するphp関数（下で定義）
        'post', //どのタイプの記事入力画面で表示するか
        'side',
        'high'
    );
}

// ② メタボックスの中身を実装する
function html_for_metabox_tw_quick_func($twquick_post){
    // 投稿のタイトルを取得
    $twquick_title = sanitize_text_field($twquick_post->post_title);
    // 投稿のURLを取得
    $twquick_link = get_permalink($twquick_post_ID);
    $twquick_twitter_url='https://twitter.com/intent/tweet?text='.$twquick_title.'&url='.$twquick_link;
    $twquick_tweet = '<a href="'.esc_url($twquick_twitter_url).'" target="_blank" rel="noopener">ツイートする</a>';
    $twquick_allowed_html = array(
        'a' => array( 'href' => array (), 'class' => array (), 'target' => array(), 'rel' => array(), ),
    );
    echo wp_kses($twquick_tweet,$twquick_allowed_html);
}
// ④ カスタムフィールド用のメタボックスを追加する
add_action('admin_menu', 'hook_func_for_metabox_tw_quick');

?>