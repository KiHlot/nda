<?php
  
  function get_input(array $data): string
  {
    return '
			<div class="input_wrapper '.($data['is_inverted'] ? 'inverted' : '').'">
			<div class="label">'.$data['label'].'</div>
				<input
					type="'.($data['type'] ?? 'text').'"
					name="'.$data['name'].'"
					value="'.($data['value'] ?? '').'"
					placeholder="'.($data['placeholder'] ?? '').'"
					autocomplete="off"
				/>
				<div class="input_error"></div>
			</div>';
  }