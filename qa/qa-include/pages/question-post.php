<?php
/*
	Question2Answer by Gideon Greenspan and contributors
	http://www.question2answer.org/

	File: qa-include/qa-page-question-post.php
	Description: More control for question page if it's submitted by HTTP POST


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}

	require_once QA_INCLUDE_DIR.'app/limits.php';
	require_once QA_INCLUDE_DIR.'pages/question-submit.php';


	$code=qa_post_text('code');


//	Process general cancel button

	if (qa_clicked('docancel'))
		qa_page_q_refresh($pagestart);


//	Process incoming answer (or button)

	if ($question['answerbutton']) {
		if (qa_clicked('q_doanswer'))
			qa_page_q_refresh($pagestart, 'answer');

		// The 'approve', 'login', 'confirm', 'limit', 'userblock', 'ipblock' permission errors are reported to the user here
		// The other option ('level') prevents the answer button being shown, in qa_page_q_post_rules(...)

		if (qa_clicked('a_doadd') || ($pagestate=='answer'))
			switch (qa_user_post_permit_error('permit_post_a', $question, QA_LIMIT_ANSWERS)) {
				case 'login':
					$pageerror=qa_insert_login_links(qa_lang_html('question/answer_must_login'), qa_request());
					break;

				case 'confirm':
					$pageerror=qa_insert_login_links(qa_lang_html('question/answer_must_confirm'), qa_request());
					break;

				case 'approve':
					$pageerror=qa_lang_html('question/answer_must_be_approved');
					break;

				case 'limit':
					$pageerror=qa_lang_html('question/answer_limit');
					break;

				default:
					$pageerror=qa_lang_html('users/no_permission');
					break;

				case false:
					if (qa_clicked('a_doadd')) {
						$answerid=qa_page_q_add_a_submit($question, $answers, $usecaptcha, $anewin, $anewerrors);

						if (isset($answerid))
							qa_page_q_refresh(0, null, 'A', $answerid);
						else
							$formtype='a_add'; // show form again

					} else
						$formtype='a_add'; // show form as if first time
					break;
			}
	}


//	Process close buttons for question

	if ($question['closeable']) {
		if (qa_clicked('q_doclose'))
			qa_page_q_refresh($pagestart, 'close');

		elseif (qa_clicked('doclose') && qa_page_q_permit_edit($question, 'permit_close_q', $pageerror)) {
			if (qa_page_q_close_q_submit($question, $closepost, $closein, $closeerrors))
				qa_page_q_refresh($pagestart);
			else
				$formtype='q_close'; // keep editing if an error

		} elseif (($pagestate=='close') && qa_page_q_permit_edit($question, 'permit_close_q', $pageerror))
			$formtype='q_close';
	}


//	Process any single click operations or delete button for question

	if (qa_page_q_single_click_q($question, $answers, $commentsfollows, $closepost, $pageerror))
		qa_page_q_refresh($pagestart);

	if (qa_clicked('q_dodelete') && $question['deleteable'] && qa_page_q_click_check_form_code($question, $pageerror)) {
		qa_question_delete($question, $userid, qa_get_logged_in_handle(), $cookieid, $closepost);
		qa_redirect(''); // redirect since question has gone
	}


//	Process edit or save button for question

	if ($question['editbutton'] || $question['retagcatbutton']) {
		if (qa_clicked('q_doedit'))
			qa_page_q_refresh($pagestart, 'edit-'.$questionid);

		elseif (qa_clicked('q_dosave') && qa_page_q_permit_edit($question, 'permit_edit_q', $pageerror, 'permit_retag_cat')) {
			if (qa_page_q_edit_q_submit($question, $answers, $commentsfollows, $closepost, $qin, $qerrors))
				qa_redirect(qa_q_request($questionid, $qin['title'])); // don't use refresh since URL may have changed

			else {
				$formtype='q_edit'; // keep editing if an error
				$pageerror=@$qerrors['page']; // for security code failure
			}

		} elseif (($pagestate==('edit-'.$questionid)) && qa_page_q_permit_edit($question, 'permit_edit_q', $pageerror, 'permit_retag_cat'))
			$formtype='q_edit';

		if ($formtype=='q_edit') { // get tags for auto-completion
			if (qa_opt('do_complete_tags'))
				$completetags=array_keys(qa_db_select_with_pending(qa_db_popular_tags_selectspec(0, QA_DB_RETRIEVE_COMPLETE_TAGS)));
			else
				$completetags=array();
		}
	}


//	Process adding a comment to question (shows form or processes it)

	if ($question['commentbutton']) {
		if (qa_clicked('q_docomment'))
			qa_page_q_refresh($pagestart, 'comment-'.$questionid);

		if (qa_clicked('c'.$questionid.'_doadd') || ($pagestate==('comment-'.$questionid)))
			qa_page_q_do_comment($question, $question, $commentsfollows, $pagestart, $usecaptcha, $cnewin, $cnewerrors, $formtype, $formpostid, $pageerror);
	}


//	Process clicked buttons for answers

	foreach ($answers as $answerid => $answer) {
		$prefix='a'.$answerid.'_';

		if (qa_page_q_single_click_a($answer, $question, $answers, $commentsfollows, true, $pageerror))
			qa_page_q_refresh($pagestart, null, 'A', $answerid);

		if ($answer['editbutton']) {
			if (qa_clicked($prefix.'doedit'))
				qa_page_q_refresh($pagestart, 'edit-'.$answerid);

			elseif (qa_clicked($prefix.'dosave') && qa_page_q_permit_edit($answer, 'permit_edit_a', $pageerror)) {
				$editedtype=qa_page_q_edit_a_submit($answer, $question, $answers, $commentsfollows, $aeditin[$answerid], $aediterrors[$answerid]);

				if (isset($editedtype))
					qa_page_q_refresh($pagestart, null, $editedtype, $answerid);

				else {
					$formtype='a_edit';
					$formpostid=$answerid; // keep editing if an error
				}

			} elseif (($pagestate==('edit-'.$answerid)) && qa_page_q_permit_edit($answer, 'permit_edit_a', $pageerror)) {
				$formtype='a_edit';
				$formpostid=$answerid;
			}
		}

		if ($answer['commentbutton']) {
			if (qa_clicked($prefix.'docomment'))
				qa_page_q_refresh($pagestart, 'comment-'.$answerid, 'A', $answerid);

			if (qa_clicked('c'.$answerid.'_doadd') || ($pagestate==('comment-'.$answerid)))
				qa_page_q_do_comment($question, $answer, $commentsfollows, $pagestart, $usecaptcha, $cnewin, $cnewerrors, $formtype, $formpostid, $pageerror);
		}

		if (qa_clicked($prefix.'dofollow')) {
			$params=array('follow' => $answerid);
			if (isset($question['categoryid']))
				$params['cat']=$question['categoryid'];

			qa_redirect('ask', $params);
		}
	}


//	Process hide, show, delete, flag, unflag, edit or save button for comments

	foreach ($commentsfollows as $commentid => $comment) {
		if ($comment['basetype'] == 'C') {
			$cparentid = $comment['parentid'];
			$commentparent = isset($answers[$cparentid]) ? $answers[$cparentid] : $question;
			$prefix = 'c'.$commentid.'_';

			if (qa_page_q_single_click_c($comment, $question, $commentparent, $pageerror))
				qa_page_q_refresh($pagestart, 'showcomments-'.$cparentid, $commentparent['basetype'], $cparentid);

			if ($comment['editbutton']) {
				if (qa_clicked($prefix.'doedit')) {
					if (qa_page_q_permit_edit($comment, 'permit_edit_c', $pageerror)) // extra check here ensures error message is visible
						qa_page_q_refresh($pagestart, 'edit-'.$commentid, 'C', $commentid);
				}
				elseif (qa_clicked($prefix.'dosave') && qa_page_q_permit_edit($comment, 'permit_edit_c', $pageerror)) {
					if (qa_page_q_edit_c_submit($comment, $question, $commentparent, $ceditin[$commentid], $cediterrors[$commentid]))
						qa_page_q_refresh($pagestart, null, 'C', $commentid);
					else {
						$formtype = 'c_edit';
						$formpostid = $commentid; // keep editing if an error
					}
				}
				elseif (($pagestate == ('edit-'.$commentid)) && qa_page_q_permit_edit($comment, 'permit_edit_c', $pageerror)) {
					$formtype = 'c_edit';
					$formpostid = $commentid;
				}
			}
		}
	}


//	Functions used above - also see functions in qa-page-question-submit.php (which are shared with Ajax)

	function qa_page_q_refresh($start=0, $state=null, $showtype=null, $showid=null)
/*
	Redirects back to the question page, with the specified parameters
*/
	{
		$params=array();

		if ($start>0)
			$params['start']=$start;
		if (isset($state))
			$params['state']=$state;

		if (isset($showtype) && isset($showid)) {
			$anchor=qa_anchor($showtype, $showid);
			$params['show']=$showid;
		} else
			$anchor=null;

		qa_redirect(qa_request(), $params, null, null, $anchor);
	}


	function qa_page_q_permit_edit($post, $permitoption, &$error, $permitoption2=null)
/*
	Returns whether the editing operation (as specified by $permitoption or $permitoption2) on $post is permitted.
	If not, sets the $error variable appropriately
*/
	{
		// The 'login', 'confirm', 'userblock', 'ipblock' permission errors are reported to the user here
		// The other options ('approve', 'level') prevent the edit button being shown, in qa_page_q_post_rules(...)

		$permiterror=qa_user_post_permit_error($post['isbyuser'] ? null : $permitoption, $post);
			// if it's by the user, this will only check whether they are blocked

		if ($permiterror && isset($permitoption2)) {
			$permiterror2=qa_user_post_permit_error($post['isbyuser'] ? null : $permitoption2, $post);

			if ( ($permiterror=='level') || ($permiterror=='approve') || (!$permiterror2) ) // if it's a less strict error
				$permiterror=$permiterror2;
		}

		switch ($permiterror) {
			case 'login':
				$error=qa_insert_login_links(qa_lang_html('question/edit_must_login'), qa_request());
				break;

			case 'confirm':
				$error=qa_insert_login_links(qa_lang_html('question/edit_must_confirm'), qa_request());
				break;

			default:
				$error=qa_lang_html('users/no_permission');
				break;

			case false:
				break;
		}

		return !$permiterror;
	}


	function qa_page_q_edit_q_form(&$qa_content, $question, $in, $errors, $completetags, $categories)
/*
	Returns a $qa_content form for editing the question and sets up other parts of $qa_content accordingly
*/
	{
		$form=array(
			'tags' => 'method="post" action="'.qa_self_html().'"',

			'style' => 'tall',

			'fields' => array(
				'title' => array(
					'type' => $question['editable'] ? 'text' : 'static',
					'label' => qa_lang_html('question/q_title_label'),
					'tags' => 'name="q_title"',
					'value' => qa_html(($question['editable'] && isset($in['title'])) ? $in['title'] : $question['title']),
					'error' => qa_html(@$errors['title']),
				),

				'category' => array(
					'label' => qa_lang_html('question/q_category_label'),
					'error' => qa_html(@$errors['categoryid']),
				),

				'content' => array(
					'label' => qa_lang_html('question/q_content_label'),
					'error' => qa_html(@$errors['content']),
				),

				'extra' => array(
					'label' => qa_html(qa_opt('extra_field_prompt')),
					'tags' => 'name="q_extra"',
					'value' => qa_html(isset($in['extra']) ? $in['extra'] : $question['extra']),
					'error' => qa_html(@$errors['extra']),
				),

				'tags' => array(
					'error' => qa_html(@$errors['tags']),
				),

			),

			'buttons' => array(
				'save' => array(
					'tags' => 'onclick="qa_show_waiting_after(this, false);"',
					'label' => qa_lang_html('main/save_button'),
				),

				'cancel' => array(
					'tags' => 'name="docancel"',
					'label' => qa_lang_html('main/cancel_button'),
				),
			),

			'hidden' => array(
				'q_dosave' => '1',
				'code' => qa_get_form_security_code('edit-'.$question['postid']),
			),
		);

		if ($question['editable']) {
			$content=isset($in['content']) ? $in['content'] : $question['content'];
			$format=isset($in['format']) ? $in['format'] : $question['format'];

			$editorname=isset($in['editor']) ? $in['editor'] : qa_opt('editor_for_qs');
			$editor=qa_load_editor($content, $format, $editorname);

			$form['fields']['content']=array_merge($form['fields']['content'],
				qa_editor_load_field($editor, $qa_content, $content, $format, 'q_content', 12, true));

			if (method_exists($editor, 'update_script'))
				$form['buttons']['save']['tags']='onclick="qa_show_waiting_after(this, false); '.$editor->update_script('q_content').'"';

			$form['hidden']['q_editor']=qa_html($editorname);

		} else
			unset($form['fields']['content']);

		if (qa_using_categories() && count($categories) && $question['retagcatable'])
			qa_set_up_category_field($qa_content, $form['fields']['category'], 'q_category', $categories,
				isset($in['categoryid']) ? $in['categoryid'] : $question['categoryid'],
				qa_opt('allow_no_category') || !isset($question['categoryid']), qa_opt('allow_no_sub_category'));
		else
			unset($form['fields']['category']);

		if (!($question['editable'] && qa_opt('extra_field_active')))
			unset($form['fields']['extra']);

		if (qa_using_tags() && $question['retagcatable'])
			qa_set_up_tag_field($qa_content, $form['fields']['tags'], 'q_tags', isset($in['tags']) ? $in['tags'] : qa_tagstring_to_tags($question['tags']),
				array(), $completetags, qa_opt('page_size_ask_tags'));
		else
			unset($form['fields']['tags']);

		if ($question['isbyuser']) {
			if (!qa_is_logged_in())
				qa_set_up_name_field($qa_content, $form['fields'], isset($in['name']) ? $in['name'] : @$question['name'], 'q_');

			qa_set_up_notify_fields($qa_content, $form['fields'], 'Q', qa_get_logged_in_email(),
				isset($in['notify']) ? $in['notify'] : !empty($question['notify']),
				isset($in['email']) ? $in['email'] : @$question['notify'], @$errors['email'], 'q_');
		}

		if (!qa_user_post_permit_error('permit_edit_silent', $question))
			$form['fields']['silent']=array(
				'type' => 'checkbox',
				'label' => qa_lang_html('question/save_silent_label'),
				'tags' => 'name="q_silent"',
				'value' => qa_html(@$in['silent']),
			);

		return $form;
	}


	function qa_page_q_edit_q_submit($question, $answers, $commentsfollows, $closepost, &$in, &$errors)
/*
	Processes a POSTed form for editing the question and returns true if successful
*/
	{
		$in=array();

		if ($question['editable']) {
			$in['title']=qa_post_text('q_title');
			qa_get_post_content('q_editor', 'q_content', $in['editor'], $in['content'], $in['format'], $in['text']);
			$in['extra']=qa_opt('extra_field_active') ? qa_post_text('q_extra') : null;
		}

		if ($question['retagcatable']) {
			if (qa_using_tags())
				$in['tags']=qa_get_tags_field_value('q_tags');

			if (qa_using_categories())
				$in['categoryid']=qa_get_category_field_value('q_category');
		}

		if (array_key_exists('categoryid', $in)) { // need to check if we can move it to that category, and if we need moderation
			$categories=qa_db_select_with_pending(qa_db_category_nav_selectspec($in['categoryid'], true));
			$categoryids=array_keys(qa_category_path($categories, $in['categoryid']));
			$userlevel=qa_user_level_for_categories($categoryids);

		} else
			$userlevel=null;

		if ($question['isbyuser']) {
			$in['name']=qa_post_text('q_name');
			$in['notify'] = qa_post_text('q_notify') !== null;
			$in['email']=qa_post_text('q_email');
		}

		if (!qa_user_post_permit_error('permit_edit_silent', $question))
			$in['silent']=qa_post_text('q_silent');

		// here the $in array only contains values for parts of the form that were displayed, so those are only ones checked by filters

		$errors=array();

		if (!qa_check_form_security_code('edit-'.$question['postid'], qa_post_text('code')))
			$errors['page']=qa_lang_html('misc/form_security_again');

		else {
			$in['queued']=qa_opt('moderate_edited_again') && qa_user_moderation_reason($userlevel);

			$filtermodules=qa_load_modules_with('filter', 'filter_question');
			foreach ($filtermodules as $filtermodule) {
				$oldin=$in;
				$filtermodule->filter_question($in, $errors, $question);

	<?php
/*
	Question2Answer by Gideon Greenspan and contributors
	http://www.question2answer.org/

	File: qa-include/qa-page-question-post.php
	Description: More control for question page if it's submitted by HTTP POST


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}

	require_once QA_INCLUDE_DIR.'app/limits.php';
	require_once QA_INCLUDE_DIR.'pages/question-submit.php';


	$code=qa_post_text('code');


//	Process general cancel button

	if (qa_clicked('docancel'))
		qa_page_q_refresh($pagestart);


//	Process incoming answer (or button)

	if ($question['answerbutton']) {
		if (qa_clicked('q_doanswer'))
			qa_page_q_refresh($pagestart, 'answer');

		// The 'approve', 'login', 'confirm', 'limit', 'userblock', 'ipblock' permission errors are reported to the user here
		// The other option ('level') prevents the answer button being shown, in qa_page_q_post_rules(...)

		if (qa_clicked('a_doadd') || ($pagestate=='answer'))
			switch (qa_user_post_permit_error('permit_post_a', $question, QA_LIMIT_ANSWERS)) {
				case 'login':
					$pageerror=qa_insert_login_links(qa_lang_html('question/answer_must_login'), qa_request());
					break;

				case 'confirm':
					$pageerror=qa_insert_login_links(qa_lang_html('question/answer_must_confirm'), qa_request());
					break;

				case 'approve':
					$pageerror=qa_lang_html('question/answer_must_be_approved');
					break;

				case 'limit':
					$pageerror=qa_lang_html('question/answer_limit');
					break;

				default:
					$pageerror=qa_lang_html('users/no_permission');
					break;

				case false:
					if (qa_clicked('a_doadd')) {
						$answerid=qa_page_q_add_a_submit($question, $answers, $usecaptcha, $anewin, $anewerrors);

						if (isset($answerid))
							qa_page_q_refresh(0, null, 'A', $answerid);
						else
							$formtype='a_add'; // show form again

					} else
						$formtype='a_add'; // show form as if first time
					break;
			}
	}


//	Process close buttons for question

	if ($question['closeable']) {
		if (qa_clicked('q_doclose'))
			qa_page_q_refresh($pagestart, 'close');

		elseif (qa_clicked('doclose') && qa_page_q_permit_edit($question, 'permit_close_q', $pageerror)) {
			if (qa_page_q_close_q_submit($question, $closepost, $closein, $closeerrors))
				qa_page_q_refresh($pagestart);
			else
				$formtype='q_close'; // keep editing if an error

		} elseif (($pagestate=='close') && qa_page_q_permit_edit($question, 'permit_close_q', $pageerror))
			$formtype='q_close';
	}


//	Process any single click operations or delete button for question

	if (qa_page_q_single_click_q($question, $answers, $commentsfollows, $closepost, $pageerror))
		qa_page_q_refresh($pagestart);

	if (qa_clicked('q_dodelete') && $question['deleteable'] && qa_page_q_click_check_form_code($question, $pageerror)) {
		qa_question_delete($question, $userid, qa_get_logged_in_handle(), $cookieid, $closepost);
		qa_redirect(''); // redirect since question has gone
	}


//	Process edit or save button for question

	if ($question['editbutton'] || $question['retagcatbutton']) {
		if (qa_clicked('q_doedit'))
			qa_page_q_refresh($pagestart, 'edit-'.$questionid);

		elseif (qa_clicked('q_dosave') && qa_page_q_permit_edit($question, 'permit_edit_q', $pageerror, 'permit_retag_cat')) {
			if (qa_page_q_edit_q_submit($question, $answers, $commentsfollows, $closepost, $qin, $qerrors))
				qa_redirect(qa_q_request($questionid, $qin['title'])); // don't use refresh since URL may have changed

			else {
				$formtype='q_edit'; // keep editing if an error
				$pageerror=@$qerrors['page']; // for security code failure
			}

		} elseif (($pagestate==('edit-'.$questionid)) && qa_page_q_permit_edit($question, 'permit_edit_q', $pageerror, 'permit_retag_cat'))
			$formtype='q_edit';

		if ($formtype=='q_edit') { // get tags for auto-completion
			if (qa_opt('do_complete_tags'))
				$completetags=array_keys(qa_db_select_with_pending(qa_db_popular_tags_selectspec(0, QA_DB_RETRIEVE_COMPLETE_TAGS)));
			else
				$completetags=array();
		}
	}


//	Process adding a comment to question (shows form or processes it)

	if ($question['commentbutton']) {
		if (qa_clicked('q_docomment'))
			qa_page_q_refresh($pagestart, 'comment-'.$questionid);

		if (qa_clicked('c'.$questionid.'_doadd') || ($pagestate==('comment-'.$questionid)))
			qa_page_q_do_comment($question, $question, $commentsfollows, $pagestart, $usecaptcha, $cnewin, $cnewerrors, $formtype, $formpostid, $pageerror);
	}


//	Process clicked buttons for answers

	foreach ($answers as $answerid => $answer) {
		$prefix='a'.$answerid.'_';

		if (qa_page_q_single_click_a($answer, $question, $answers, $commentsfollows, true, $pageerror))
			qa_page_q_refresh($pagestart, null, 'A', $answerid);

		if ($answer['editbutton']) {
			if (qa_clicked($prefix.'doedit'))
				qa_page_q_refresh($pagestart, 'edit-'.$answerid);

			elseif (qa_clicked($prefix.'dosave') && qa_page_q_permit_edit($answer, 'permit_edit_a', $pageerror)) {
				$editedtype=qa_page_q_edit_a_submit($answer, $question, $answers, $commentsfollows, $aeditin[$answerid], $aediterrors[$answerid]);

				if (isset($editedtype))
					qa_page_q_refresh($pagestart, null, $editedtype, $answerid);

				else {
					$formtype='a_edit';
					$formpostid=$answerid; // keep editing if an error
				}

			} elseif (($pagestate==('edit-'.$answerid)) && qa_page_q_permit_edit($answer, 'permit_edit_a', $pageerror)) {
				$formtype='a_edit';
				$formpostid=$answerid;
			}
		}

		if ($answer['commentbutton']) {
			if (qa_clicked($prefix.'docomment'))
				qa_page_q_refresh($pagestart, 'comment-'.$answerid, 'A', $answerid);

			if (qa_clicked('c'.$answerid.'_doadd') || ($pagestate==('comment-'.$answerid)))
				qa_page_q_do_comment($question, $answer, $commentsfollows, $pagestart, $usecaptcha, $cnewin, $cnewerrors, $formtype, $formpostid, $pageerror);
		}

		if (qa_clicked($prefix.'dofollow')) {
			$params=array('follow' => $answerid);
			if (isset($question['categoryid']))
				$params['cat']=$question['categoryid'];

			qa_redirect('ask', $params);
		}
	}


//	Process hide, show, delete, flag, unflag, edit or save button for comments

	foreach ($commentsfollows as $commentid => $comment) {
		if ($comment['basetype'] == 'C') {
			$cparentid = $comment['parentid'];
			$commentparent = isset($answers[$cparentid]) ? $answers[$cparentid] : $question;
			$prefix = 'c'.$commentid.'_';

			if (qa_page_q_single_click_c($comment, $question, $commentparent, $pageerror))
				qa_page_q_refresh($pagestart, 'showcomments-'.$cparentid, $commentparent['basetype'], $cparentid);

			if ($comment['editbutton']) {
				if (qa_clicked($prefix.'doedit')) {
					if (qa_page_q_permit_edit($comment, 'permit_edit_c', $pageerror)) // extra check here ensures error message is visible
						qa_page_q_refresh($pagestart, 'edit-'.$commentid, 'C', $commentid);
				}
				elseif (qa_clicked($prefix.'dosave') && qa_page_q_permit_edit($comment, 'permit_edit_c', $pageerror)) {
					if (qa_page_q_edit_c_submit($comment, $question, $commentparent, $ceditin[$commentid], $cediterrors[$commentid]))
						qa_page_q_refresh($pagestart, null, 'C', $commentid);
					else {
						$formtype = 'c_edit';
						$formpostid = $commentid; // keep editing if an error
					}
				}
				elseif (($pagestate == ('edit-'.$commentid)) && qa_page_q_permit_edit($comment, 'permit_edit_c', $pageerror)) {
					$formtype = 'c_edit';
					$formpostid = $commentid;
				}
			}
		}
	}


//	Functions used above - also see functions in qa-page-question-submit.php (which are shared with Ajax)

	function qa_page_q_refresh($start=0, $state=null, $showtype=null, $showid=null)
/*
	Redirects back to the question page, with the specified parameters
*/
	{
		$params=array();

		if ($start>0)
			$params['start']=$start;
		if (isset($state))
			$params['state']=$state;

		if (isset($showtype) && isset($showid)) {
			$anchor=qa_anchor($showtype, $showid);
			$params['show']=$showid;
		} else
			$anchor=null;

		qa_redirect(qa_request(), $params, null, null, $anchor);
	}


	function qa_page_q_permit_edit($post, $permitoption, &$error, $permitoption2=null)
/*
	Returns whether the editing operation (as specified by $permitoption or $permitoption2) on $post is permitted.
	If not, sets the $error variable appropriately
*/
	{
		// The 'login', 'confirm', 'userblock', 'ipblock' permission errors are reported to the user here
		// The other options ('approve', 'level') prevent the edit button being shown, in qa_page_q_post_rules(...)

		$permiterror=qa_user_post_permit_error($post['isbyuser'] ? null : $permitoption, $post);
			// if it's by the user, this will only check whether they are blocked

		if ($permiterror && isset($permitoption2)) {
			$permiterror2=qa_user_post_permit_error($post['isbyuser'] ? null : $permitoption2, $post);

			if ( ($permiterror=='level') || ($permiterror=='approve') || (!$permiterror2) ) // if it's a less strict error
				$permiterror=$permiterror2;
		}

		switch ($permiterror) {
			case 'login':
				$error=qa_insert_login_links(qa_lang_html('question/edit_must_login'), qa_request());
				break;

			case 'confirm':
				$error=qa_insert_login_links(qa_lang_html('question/edit_must_confirm'), qa_request());
				break;

			default:
				$error=qa_lang_html('users/no_permission');
				break;

			case false:
				break;
		}

		return !$permiterror;
	}


	function qa_page_q_edit_q_form(&$qa_content, $question, $in, $errors, $completetags, $categories)
/*
	Returns a $qa_content form for editing the question and sets up other parts of $qa_content accordingly
*/
	{
		$form=array(
			'tags' => 'method="post" action="'.qa_self_html().'"',

			'style' => 'tall',

			'fields' => array(
				'title' => array(
					'type' => $question['editable'] ? 'text' : 'static',
					'label' => qa_lang_html('question/q_title_label'),
					'tags' => 'name="q_title"',
					'value' => qa_html(($question['editable'] && isset($in['title'])) ? $in['title'] : $question['title']),
					'error' => qa_html(@$errors['title']),
				),

				'category' => array(
					'label' => qa_lang_html('question/q_category_label'),
					'error' => qa_html(@$errors['categoryid']),
				),

				'content' => array(
					'label' => qa_lang_html('question/q_content_label'),
					'error' => qa_html(@$errors['content']),
				),

				'extra' => array(
					'label' => qa_html(qa_opt('extra_field_prompt')),
					'tags' => 'name="q_extra"',
					'value' => qa_html(isset($in['extra']) ? $in['extra'] : $question['extra']),
					'error' => qa_html(@$errors['extra']),
				),

				'tags' => array(
					'error' => qa_html(@$errors['tags']),
				),

			),

			'buttons' => array(
				'save' => array(
					'tags' => 'onclick="qa_show_waiting_after(this, false);"',
					'label' => qa_lang_html('main/save_button'),
				),

				'cancel' => array(
					'tags' => 'name="docancel"',
					'label' => qa_lang_html('main/cancel_button'),
				),
			),

			'hidden' => array(
				'q_dosave' => '1',
				'code' => qa_get_form_security_code('edit-'.$question['postid']),
			),
		);

		if ($question['editable']) {
			$content=isset($in['content']) ? $in['content'] : $question['content'];
			$format=isset($in['format']) ? $in['format'] : $question['format'];

			$editorname=isset($in['editor']) ? $in['editor'] : qa_opt('editor_for_qs');
			$editor=qa_load_editor($content, $format, $editorname);

			$form['fields']['content']=array_merge($form['fields']['content'],
				qa_editor_load_field($editor, $qa_content, $content, $format, 'q_content', 12, true));

			if (method_exists($editor, 'update_script'))
				$form['buttons']['save']['tags']='onclick="qa_show_waiting_after(this, false); '.$editor->update_script('q_content').'"';

			$form['hidden']['q_editor']=qa_html($editorname);

		} else
			unset($form['fields']['content']);

		if (qa_using_categories() && count($categories) && $question['retagcatable'])
			qa_set_up_category_field($qa_content, $form['fields']['category'], 'q_category', $categories,
				isset($in['categoryid']) ? $in['categoryid'] : $question['categoryid'],
				qa_opt('allow_no_category') || !isset($question['categoryid']), qa_opt('allow_no_sub_category'));
		else
			unset($form['fields']['category']);

		if (!($question['editable'] && qa_opt('extra_field_active')))
			unset($form['fields']['extra']);

		if (qa_using_tags() && $question['retagcatable'])
			qa_set_up_tag_field($qa_content, $form['fields']['tags'], 'q_tags', isset($in['tags']) ? $in['tags'] : qa_tagstring_to_tags($question['tags']),
				array(), $completetags, qa_opt('page_size_ask_tags'));
		else
			unset($form['fields']['tags']);

		if ($question['isbyuser']) {
			if (!qa_is_logged_in())
				qa_set_up_name_field($qa_content, $form['fields'], isset($in['name']) ? $in['name'] : @$question['name'], 'q_');

			qa_set_up_notify_fields($qa_content, $form['fields'], 'Q', qa_get_logged_in_email(),
				isset($in['notify']) ? $in['notify'] : !empty($question['notify']),
				isset($in['email']) ? $in['email'] : @$question['notify'], @$errors['email'], 'q_');
		}

		if (!qa_user_post_permit_error('permit_edit_silent', $question))
			$form['fields']['silent']=array(
				'type' => 'checkbox',
				'label' => qa_lang_html('question/save_silent_label'),
				'tags' => 'name="q_silent"',
				'value' => qa_html(@$in['silent']),
			);

		return $form;
	}


	function qa_page_q_edit_q_submit($question, $answers, $commentsfollows, $closepost, &$in, &$errors)
/*
	Processes a POSTed form for editing the question and returns true if successful
*/
	{
		$in=array();

		if ($question['editable']) {
			$in['title']=qa_post_text('q_title');
			qa_get_post_content('q_editor', 'q_content', $in['editor'], $in['content'], $in['format'], $in['text']);
			$in['extra']=qa_opt('extra_field_active') ? qa_post_text('q_extra') : null;
		}

		if ($question['retagcatable']) {
			if (qa_using_tags())
				$in['tags']=qa_get_tags_field_value('q_tags');

			if (qa_using_categories())
				$in['categoryid']=qa_get_category_field_value('q_category');
		}

		if (array_key_exists('categoryid', $in)) { // need to check if we can move it to that category, and if we need moderation
			$categories=qa_db_select_with_pending(qa_db_category_nav_selectspec($in['categoryid'], true));
			$categoryids=array_keys(qa_category_path($categories, $in['categoryid']));
			$userlevel=qa_user_level_for_categories($categoryids);

		} else
			$userlevel=null;

		if ($question['isbyuser']) {
			$in['name']=qa_post_text('q_name');
			$in['notify'] = qa_post_text('q_notify') !== null;
			$in['email']=qa_post_text('q_email');
		}

		if (!qa_user_post_permit_error('permit_edit_silent', $question))
			$in['silent']=qa_post_text('q_silent');

		// here the $in array only contains values for parts of the form that were displayed, so those are only ones checked by filters

		$errors=array();

		if (!qa_check_form_security_code('edit-'.$question['postid'], qa_post_text('code')))
			$errors['page']=qa_lang_html('misc/form_security_again');

		else {
			$in['queued']=qa_opt('moderate_edited_again') && qa_user_moderation_reason($userlevel);

			$filtermodules=qa_load_modules_with('filter', 'filter_question');
			foreach ($filtermodules as $filtermodule) {
				$oldin=$in;
				$filtermodule->filter_question($in, $errors, $question);

				if ($question['editable'])
					qa_update_post_text($in, $oldin);
			}

			if (array_key_exists('categoryid', $in) && strcmp($in['categoryid'], $question['categoryid']))
				if (qa_user_permit_error('permit_post_q', null, $userlevel))
					$errors['categoryid']=qa_lang_html('question/category_ask_not_allowed');

			if (empty($errors)) {
				$userid=qa_get_logged_in_userid();
				$handle=qa_get_logged_in_handle();
				$cookieid=qa_cookie_get();

				// now we fill in the missing values in the $in array, so that we have everything we need for qa_question_set_content()
				// we do things in this way to avoid any risk of a validation failure on elements the user can't see (e.g. due to admin setting changes)

				if (!$question['editable']) {
					$in['title']=$question['title'];
					$in['content']=$question['content'];
					$in['format']=$question['format'];
					$in['text']=qa_viewer_text($in['content'], $in['format']);
					$in['extra']=$question['extra'];
				}

				if (!isset($in['tags']))
					$in['tags']=qa_tagstring_to_tags($question['tags']);

				if (!array_key_exists('categoryid', $in))
					$in['categoryid']=$question['categoryid'];

				if (!isset($in['silent']))
					$in['silent']=false;

				$setnotify=$question['isbyuser'] ? qa_combine_notify_email($question['userid'], $in['notify'], $in['email']) : $question['notify'];

				qa_question_set_content($question, $in['title'], $in['content'], $in['format'], $in['text'], qa_tags_to_tagstring($in['tags']),
					$setnotify, $userid, $handle, $cookieid, $in['extra'], @$in['name'], $in['queued'], $in['silent']);

				if (qa_using_categories() && strcmp($in['categoryid'], $question['categoryid']))
					qa_question_set_category($question, $in['categoryid'], $userid, $handle, $cookieid,
						$answers, $commentsfollows, $closepost, $in['silent']);

				return true;
			}
		}

		return false;
	}


	function qa_page_q_close_q_form(&$qa_content, $question, $id, $in, $errors)
/*
	Returns a $qa_content form for closing the question and sets up other parts of $qa_content accordingly
*/
	{
		$form=array(
			'tags' => 'method="post" action="'.qa_self_html().'"',

			'id' => $id,

			'style' => 'tall',

			'title' => qa_lang_html('question/close_form_title'),

			'fields' => array(
				'duplicate' => array(
					'type' => 'checkbox',
					'tags' => 'name="q_close_duplicate" id="q_close_duplicate" onchange="document.getElementById(\'q_close_details\').focus();"',
					'label' => qa_lang_html('question/close_duplicate'),
					'value' => @$in['duplicate'],
				),

				'details' => array(
					'tags' => 'name="q_close_details" id="q_close_details"',
					'label' =>
						'<span id="close_l