<?php
/**
 * Create or update the shared Contact Form 7 support form.
 *
 * Usage: wp eval-file wp-content/themes/blocksy-child/bin/seed-contact-form.php
 */

if (!defined('ABSPATH')) {
	exit(1);
}

if (!class_exists('WPCF7_ContactForm')) {
	$message = 'Contact Form 7 must be active.';
	class_exists('WP_CLI') ? WP_CLI::error($message) : print($message . PHP_EOL);
	return;
}

$title = 'TTCTECH – Yêu cầu tư vấn';
$post = get_page_by_path('ttctech-yeu-cau-tu-van', OBJECT, 'wpcf7_contact_form');
$form = $post ? WPCF7_ContactForm::get_instance($post->ID) : WPCF7_ContactForm::get_template([
	'locale' => 'vi',
	'title' => $title,
]);

$mail = $form->prop('mail');
$mail['subject'] = '[_site_title] Yêu cầu tư vấn từ [your-name]';
$mail['sender'] = sprintf('[_site_title] <%s>', WPCF7_ContactFormTemplate::from_email());
$mail['body'] = "Họ và tên: [your-name]\nEmail: [your-email]\nSố điện thoại: [phone]\nCông ty: [company]\nDịch vụ quan tâm: [service]\n\nNội dung yêu cầu:\n[your-message]\n\n--\nGửi từ [_site_title] ([_site_url])";
$mail['additional_headers'] = 'Reply-To: [your-email]';

$messages = $form->prop('messages');
$messages = array_merge($messages, [
	'mail_sent_ok' => 'Cảm ơn bạn. Yêu cầu đã được gửi thành công, TTCTECH sẽ liên hệ trong giờ làm việc.',
	'mail_sent_ng' => 'Chưa thể gửi yêu cầu. Vui lòng thử lại hoặc liên hệ trực tiếp qua hotline.',
	'validation_error' => 'Vui lòng kiểm tra lại các trường được đánh dấu bên dưới.',
	'spam' => 'Yêu cầu chưa được gửi. Vui lòng thử lại sau.',
	'invalid_required' => 'Vui lòng điền thông tin này.',
	'invalid_too_long' => 'Nội dung vượt quá độ dài cho phép.',
	'invalid_too_short' => 'Nội dung chưa đủ độ dài yêu cầu.',
	'invalid_email' => 'Vui lòng nhập đúng địa chỉ email.',
	'invalid_tel' => 'Vui lòng nhập đúng số điện thoại.',
]);

$form->set_title($title);
$form->set_properties([
	'form' => <<<'FORM'
<div class="ttc-support__form-head">
<p class="ttc-support__note">Cho chúng tôi biết nhu cầu của bạn để đội ngũ kỹ thuật tư vấn đúng giải pháp.</p>
<p class="ttc-support__required"><span aria-hidden="true">*</span> Thông tin bắt buộc</p>
</div>
<div class="ttc-support__fields">
<label class="ttc-support__field"><span>Họ và tên <b aria-hidden="true">*</b></span>[text* your-name autocomplete:name placeholder "Nguyễn Văn An"]</label>
<label class="ttc-support__field"><span>Email <b aria-hidden="true">*</b></span>[email* your-email autocomplete:email placeholder "email@congty.vn"]</label>
<label class="ttc-support__field"><span>Số điện thoại <b aria-hidden="true">*</b></span>[tel* phone autocomplete:tel placeholder "09xx xxx xxx"]</label>
<label class="ttc-support__field"><span>Tên công ty</span>[text company autocomplete:organization placeholder "Công ty của bạn"]</label>
<label class="ttc-support__field ttc-support__field--wide"><span>Dịch vụ quan tâm <b aria-hidden="true">*</b></span>[select* service first_as_label "Chọn dịch vụ" "Tư vấn dụng cụ" "Hỗ trợ kỹ thuật" "Yêu cầu báo giá"]</label>
<label class="ttc-support__field ttc-support__field--wide"><span>Nội dung cần hỗ trợ</span>[textarea your-message maxlength:1000 x4 placeholder "Mô tả sản phẩm, thông số hoặc vấn đề bạn cần hỗ trợ..."]</label>
</div>
<div class="ttc-support__actions">
[submit class:ttc-support__submit "Gửi yêu cầu tư vấn"]
<span class="ttc-support__privacy">Thông tin chỉ được dùng để phản hồi yêu cầu của bạn.</span>
</div>
FORM,
	'mail' => $mail,
	'messages' => $messages,
]);

$id = $form->save();
$message = $id ? "Contact Form 7 form #{$id} is ready." : 'Could not save the Contact Form 7 form.';

if (class_exists('WP_CLI')) {
	$id ? WP_CLI::success($message) : WP_CLI::error($message);
} else {
	echo $message . PHP_EOL;
}
