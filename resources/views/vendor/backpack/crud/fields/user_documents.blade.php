@if(isset($field['value']))
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

	{{-- Show the file name and a "Clear" button on EDIT form. --}}
	@if (isset($field['value']))
	@php
		if (is_string($field['value'])) {
			$values = json_decode($field['value'], true) ?? [];
		} else {
			$values = $field['value'];
		}
        $userId = request('user');
    @endphp
	@if (count($values))
        <div class="array-container form-group">
            <table class="table table-bordered table-striped m-b-0" ng-init="field = '#options'; items = []; max = 4; min = -1; maxErrorTitle = 'Не удалось добавить новую option'; maxErrorMessage = 'Максимальное количество из 5 достигнуто'; emptyRow='{&quot;name&quot;:&quot;&quot;,&quot;desc&quot;:&quot;&quot;,&quot;price&quot;:&quot;&quot;}';">

                <thead>
                <tr>
                    <th style="font-weight: 600!important;">Документ</th>
                    <th style="font-weight: 600!important;">Тип</th>
                    <th style="font-weight: 600!important;">Статус</th>
                    <!-- ngIf: max == -1 || max > 1 --><th class="text-center ng-scope" ng-if="max == -1 || max > 1">  </th><!-- end ngIf: max == -1 || max > 1 -->
                </tr>
                </thead>

                <tbody ui-sortable="sortableOptions" ng-model="items" class="table-striped ng-pristine ng-untouched ng-valid ng-isolate-scope ui-sortable ng-not-empty">
                @php /** @var \App\Entity\User\Verification\Document $doc */ @endphp
                @foreach($values as $key => $doc)
                    @php
                        $file_path = $doc->getPath();
                        $file_crop = $doc->getCrop();
                    @endphp

                    <tr>
                        <td><a target="_blank" href="{{ route('doc', $doc) }}"><img src="{{ asset($file_crop)  }}"></a></td>
                        <td>
                            @if($doc->isDocument())
                                <span class="badge btn-info">Документ</span>
                            @endif
                            @if($doc->isCertificate())
                                <span class="badge">Сертификат</span>
                            @endif
                            @if($doc->isPassport())
                                <span class="badge btn-info">Паспорт</span>
                            @endif
                            @if($doc->isJuristic())
                                <span class="badge btn-warning">Для юр.лиц</span>
                            @endif
                        </td>
                        <td>
                            @if(!$doc->isCertificate())
                                @if($doc->isRejected())
                                    <span class="badge btn-danger">Отклонён</span>
                                @endif
                                @if($doc->isVerified())
                                    <span class="badge btn-success">Верифицирован</span>
                                @endif
                                @if($doc->isWait())
                                    <span class="badge btn-primary">Ожидает верификации</span>
                                @endif
                            @endif

                            @if($doc->isPublic())
                                <span class="badge btn-success">Общедоступный</span>
                            @endif
                            @if($doc->isPrivate() && $doc->isCertificate())
                                <span class="badge btn-primary">Приватный</span>
                            @endif
                        </td>
                        <td>
                            @if(!$doc->isRejected() && $doc->isCertificate())
                                @if($doc->isPublic())
                                    <a href="{{ backpack_url("users/{$userId}/edit?action=private&doc={$doc->id}#dannyeverifikatsii") }}" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Сделать приватным</a>
                                @else
                                    <a href="{{ backpack_url("users/{$userId}/edit?action=public&doc={$doc->id}#dannyeverifikatsii") }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Сделать публичным</a>
                                @endif
                            @endif

                            @if($doc->isRejected())
                                <a href="{{ backpack_url("users/{$userId}/edit?action=remove&doc={$doc->id}#dannyeverifikatsii") }}" class="btn btn-xs btn-danger"><i class="fa fa-remove"></i> Удалить</a>
                            @endif

                            @if($doc->isWait() && ($doc->isPassport() || $doc->isJuristic() || $doc->isDocument()))
                                <a href="{{ backpack_url("users/{$userId}/edit?action=verify&doc={$doc->id}#dannyeverifikatsii") }}" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Верифицировать</a>
                                <a href="{{ backpack_url("users/{$userId}/edit?action=reject&doc={$doc->id}#dannyeverifikatsii") }}" class="btn btn-xs btn-danger"><i class="fa fa-edit"></i> Отклонить</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    @endif
    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
@endif
{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script>
	        $(".file-clear-button").click(function(e) {
	        	e.preventDefault();
	        	var container = $(this).parent().parent();
	        	var parent = $(this).parent();
	        	// remove the filename and button
	        	parent.remove();
	        	// if the file container is empty, remove it
	        	if ($.trim(container.html())=='') {
	        		container.remove();
	        	}
	        	$("<input type='hidden' name='clear_{{ $field['name'] }}[]' value='"+$(this).data('filename')+"'>").insertAfter("#{{ $field['name'] }}_file_input");
	        });

	        $("#{{ $field['name'] }}_file_input").change(function() {
	        	console.log($(this).val());
	        	// remove the hidden input, so that the setXAttribute method is no longer triggered
	        	$(this).next("input[type=hidden]").remove();
	        });
        </script>
    @endpush
