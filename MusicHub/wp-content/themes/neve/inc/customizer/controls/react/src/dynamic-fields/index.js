/* global NeveReactCustomize */
import DynamicFieldInserter from './dynamic-field-inserter.js';

/**
 * Initialize the dynamic tag buttons.
 *
 * @returns {boolean}|{void}
 */
export const init = function() {
	if ( !NeveReactCustomize.dynamicTags ) {
		return false;
	}
	const controls = NeveReactCustomize.dynamicTags.controls;
	NeveReactCustomize.fieldSelection = {};
	Object.keys( controls ).forEach( function(controlId, index) {
		let control = wp.customize.control( controlId ),
				container = control.container[0],
				dynamicControlWrap = document.createElement( 'div' );

		dynamicControlWrap.setAttribute( 'id', `dynamic-${controlId}` );
		dynamicControlWrap.classList.add( 'neve-dynamic-tag-selector' );
		container.classList.add( 'neve-has-dynamic-tag-selector' );
		container.appendChild( dynamicControlWrap );

		const input = document.querySelector(
				`[data-customize-setting-link="${control.id}"]` );

		input.addEventListener( 'focusout', function(e) {
			NeveReactCustomize.fieldSelection[controlId] = {
				start: e.target.selectionStart,
				end: e.target.selectionEnd
			};
		} );

		ReactDOM.render(
				<DynamicFieldInserter
						allowedOptionsTypes={
							controls[controlId]
						}
						onSelect={
							(magicTag, group) => addToField( magicTag, control, group )
						}
				/>,
				dynamicControlWrap
		);
	} );
};

/**
 * Add dynamic tag to input field.
 * @param magicTag
 * @param control
 * @param optionType
 */
const addToField = function(magicTag, control, optionType) {
	let tag;
	const input = document.querySelector(
			`[data-customize-setting-link="${control.id}"]` );

	if ( optionType === 'url' && control.params.type === 'textarea' ) {
		tag = `<a href="{${magicTag}}">Link</a>`;
	} else {
		tag = `{${magicTag}}`;
	}

	if ( optionType === 'url' && input.value === '#' ) {
		input.value = tag;
	} else if ( NeveReactCustomize.fieldSelection[control.id] ) {
		let { start, end } = NeveReactCustomize.fieldSelection[control.id],
				length = input.value.length;
		input.value =
				input.value.substring( 0, start ) + tag +
				input.value.substring( end, length );
	} else {
		input.value += tag;
	}
	NeveReactCustomize.fieldSelection[control.id] = false;
	input.focus();
	input.dispatchEvent( new Event( 'change' ) );
};
