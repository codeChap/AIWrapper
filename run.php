<?php

require __DIR__ . '/vendor/autoload.php';

use codechap\ai\ai;

//Get the API Key
$xaiKey = file_get_contents(realpath(__DIR__ . '/..') . '/X-API-KEY.txt');
$groqKey = file_get_contents(realpath(__DIR__ . '/..') . '/GROQ-API-KEY.txt');
$openaiKey = file_get_contents(realpath(__DIR__ . '/..') . '/OPENAI-API-KEY.txt');
$anthropicKey = file_get_contents(realpath(__DIR__ . '/..') . '/ANTHROPIC-API-KEY.txt');
$mistralKey = file_get_contents(realpath(__DIR__ . '/..') . '/MISTRAL-API-KEY.txt');

// Anthropic Test
print "### Anthropic Test ### \n";
$anthropic = new ai('anthropic', $anthropicKey);
print $anthropic
    ->set('temperature', 0)
    ->set('model', 'claude-3-5-sonnet-20241022')
    ->set('systemPrompt', 'You are a helpful assistant from planet earth.')
    ->set('stream', false)
    ->query("What is the capital of South Africa?")
    ->one()
    ;
print "\n\n";

// Groq Test
print "### Groq Test ### \n";
$groq = new ai('groq', $groqKey);
print $groq
    ->set('temperature', 0)
    ->set('model', 'deepseek-r1-distill-llama-70b')
    ->set('systemPrompt', 'You are a helpful assistant from planet earth.')
    ->set('stream', false)
    ->query("What is the capital of South Africa?")
    ->one()
    ;
print "\n\n";

// Mistral Test
print "### Mistral Test ### \n";
$mistral = new ai('mistral', $mistralKey);
print $mistral
    ->set('temperature', 0)
    ->set('model', 'mistral-large-latest')
    ->set('systemPrompt', 'You are a helpful assistant from planet earth.')
    ->set('stream', false)
    ->query("What is the capital of South Africa?")
    ->one()
    ;
print "\n\n";

// OpenAI Test
print "### OpenAI Test ### \n";
$openai = new ai('openai', $openaiKey);
print $openai
    ->set('temperature', 0)
    ->set('model', 'gpt-4o-mini')
    ->set('systemPrompt', 'You are a helpful assistant from planet earth.')
    ->set('stream', false)
    ->query("What is the capital of South Africa?")
    ->one()
    ;
print "\n\n";

// xAI Test
print "### xAI Test ### \n";
$xai = new ai('xai', $xaiKey);
print $xai
    ->set('temperature', 0)
    ->set('model', 'grok-2-latest')
    ->set('systemPrompt', 'You are a helpful assistant from planet earth.')
    ->set('stream', false)
    ->query("What is the capital of South Africa?")
    ->one()
    ;
print "\n\n";
?>
