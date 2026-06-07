@php
    $editorId = $editorId ?? 'newsContentEditor';
    $inputId = $inputId ?? 'newsContentInput';
    $content = $content ?? '';
    $sanitizedContent = \App\Support\NewsContentSanitizer::sanitize($content);
@endphp

<div class="overflow-hidden rounded-xl border border-slate-300 bg-white focus-within:ring-2 focus-within:ring-emerald-500">
    <div class="flex flex-wrap items-center gap-1 border-b border-slate-200 bg-slate-50 p-2" data-rich-toolbar="{{ $editorId }}">
        <button type="button" data-command="formatBlock" data-value="p" class="rich-editor-btn">P</button>
        <button type="button" data-command="formatBlock" data-value="h2" class="rich-editor-btn">H2</button>
        <button type="button" data-command="formatBlock" data-value="h3" class="rich-editor-btn">H3</button>
        <span class="mx-1 h-6 w-px bg-slate-300"></span>
        <button type="button" data-command="bold" class="rich-editor-btn font-bold">B</button>
        <button type="button" data-command="italic" class="rich-editor-btn italic">I</button>
        <button type="button" data-command="underline" class="rich-editor-btn underline">U</button>
        <button type="button" data-command="strikeThrough" class="rich-editor-btn line-through">S</button>
        <span class="mx-1 h-6 w-px bg-slate-300"></span>
        <button type="button" data-command="insertUnorderedList" class="rich-editor-btn">• List</button>
        <button type="button" data-command="insertOrderedList" class="rich-editor-btn">1. List</button>
        <button type="button" data-command="outdent" class="rich-editor-btn">Outdent</button>
        <button type="button" data-command="indent" class="rich-editor-btn">Indent</button>
        <span class="mx-1 h-6 w-px bg-slate-300"></span>
        <button type="button" data-command="justifyLeft" class="rich-editor-btn">Left</button>
        <button type="button" data-command="justifyCenter" class="rich-editor-btn">Center</button>
        <button type="button" data-command="justifyRight" class="rich-editor-btn">Right</button>
        <button type="button" data-command="justifyFull" class="rich-editor-btn">Justify</button>
        <span class="mx-1 h-6 w-px bg-slate-300"></span>
        <button type="button" data-command="formatBlock" data-value="blockquote" class="rich-editor-btn">Quote</button>
        <button type="button" data-command="createLink" class="rich-editor-btn">Link</button>
        <button type="button" data-command="removeFormat" class="rich-editor-btn">Clear</button>
    </div>

    <div
        id="{{ $editorId }}"
        class="rich-editor-content min-h-[320px] px-4 py-3 text-sm leading-7 text-slate-800 focus:outline-none"
        contenteditable="true"
        data-target="{{ $inputId }}"
    >{!! $sanitizedContent !!}</div>
</div>

<textarea id="{{ $inputId }}" name="content" class="hidden">{{ $sanitizedContent }}</textarea>

@once
    @push('styles')
        <style>
            .rich-editor-btn {
                min-height: 2rem;
                border-radius: 0.5rem;
                padding: 0.35rem 0.55rem;
                font-size: 0.75rem;
                font-weight: 700;
                color: #475569;
                transition: background-color 150ms ease, color 150ms ease;
            }

            .rich-editor-btn:hover {
                background: #e2e8f0;
                color: #0f172a;
            }

            .rich-editor-content h2 {
                margin: 1rem 0 0.5rem;
                font-size: 1.5rem;
                font-weight: 800;
                line-height: 1.3;
            }

            .rich-editor-content h3 {
                margin: 0.85rem 0 0.45rem;
                font-size: 1.2rem;
                font-weight: 800;
                line-height: 1.35;
            }

            .rich-editor-content p,
            .rich-editor-content ul,
            .rich-editor-content ol,
            .rich-editor-content blockquote {
                margin: 0.75rem 0;
            }

            .rich-editor-content ul,
            .rich-editor-content ol {
                padding-left: 1.5rem;
            }

            .rich-editor-content ul {
                list-style: disc;
            }

            .rich-editor-content ol {
                list-style: decimal;
            }

            .rich-editor-content blockquote {
                border-left: 4px solid #10b981;
                padding-left: 1rem;
                color: #475569;
                font-style: italic;
            }

            .rich-editor-content a {
                color: #047857;
                font-weight: 700;
                text-decoration: underline;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.rich-editor-content').forEach((editor) => {
                const input = document.getElementById(editor.dataset.target);
                const toolbar = document.querySelector(`[data-rich-toolbar="${editor.id}"]`);

                if (!input || !toolbar) return;

                const syncContent = () => {
                    input.value = editor.innerHTML.trim();
                };

                toolbar.querySelectorAll('[data-command]').forEach((button) => {
                    button.addEventListener('click', () => {
                        const command = button.dataset.command;
                        let value = button.dataset.value || null;

                        editor.focus();

                        if (command === 'createLink') {
                            value = window.prompt('Masukkan URL tautan');

                            if (!value) return;
                        }

                        document.execCommand(command, false, value);
                        syncContent();
                    });
                });

                editor.addEventListener('input', syncContent);
                editor.closest('form')?.addEventListener('submit', syncContent);
                syncContent();
            });
        });
        </script>
    @endpush
@endonce
