## FAQs

#### Default Settings:

<table>
	<thead>
		<tr>
			<th>Option</th>
			<th>Default value</th>
			<th>Description/Callback signature</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Shortcode</strong></td>
			<td>Enabled</td>
			<td></td>
		</tr>
		<tr>
			<td><strong>Auto Breakline</strong></td>
			<td>Enabled</td>
			<td></td>
		</tr>
		<tr>
			<td><strong>Max Width</strong></td>
			<td>600px</td>
			<td></td>
		</tr>
		<tr>
			<td><strong>Header Alignment</strong></td>
			<td>Center</td>
			<td></td>
		</tr>
		<tr>
			<td><strong>Footer Alignment</strong></td>
			<td>center</td>
			<td></td>
		</tr>
	</tbody>
</table>


#### Tag Limitation:

<table>
	<thead>
		<tr>
			<th>Option</th>
			<th>Default value</th>
			<th>Description/Callback signature</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Default Tags</strong></td>
			<td></td>
			<td>Header, Content, and Footer are inside td element</td>
		</tr>
		<tr>
			<td><strong>CSS</strong></td>
			<td></td>
			<td>Inline style</td>
		</tr>
		<tr>
			<td><strong>Tags</strong></td>
			<td></td>
			<td>div, table, th, tr, td, img, p, a, em, strong</td>
		</tr>
	</tbody>
</table>

```html
<div style="font-family:Arial, sans-serif; font-size:14px; line-height: 22px; color:#545454; text-decoration:none; font-weight:normal; margin:0 !important; letter-spacing:0;"></div>
```

```html
<img src="" width="" height="" style="max-width: 400px;">
```

#### Web Safe Fonts:

<table>
	<thead>
		<tr>
			<th>Option</th>
			<th>Default value</th>
			<th>Description/Callback signature</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>sans-serif</strong></td>
			<td></td>
			<td>Helvetica, Arial, Verdana, Trebuchet MS</td>
		</tr>
		<tr>
			<td><strong>serif</strong></td>
			<td></td>
			<td>Georgia, Times New Roman, Courier</td>
		</tr>
	</tbody>
</table>

#### Social Media:

<table>
	<thead>
		<tr>
			<th>Option</th>
			<th>Default value</th>
			<th>Description/Callback signature</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Theme</strong></td>
			<td>dark</td>
			<td>colored | dark</td>
		</tr>
		<tr>
			<td><strong>List</strong></td>
			<td></td>
			<td>
				* facebook
				* twitter
				* instagram
				* linkedin
				* google-plus
				* yelp
				* youtube
				* snapchat
				* whatsapp
				* skype
				* link
			</td>
		</tr>
	</tbody>
</table>

```html
<a href="#" target="_blank" style="display: inline-block; text-decoration: none; margin: 0 7px;"><img src="URL" width="18" height="18"></a>
```

## Template
```html
<table width="600" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="2" style="font-size: 16px; font-weight: 700;">PERSONAL INFORMATION</td>
	</tr>
	<tr>
		<td width="200"><strong>Name:</strong></td>
		<td>[your-name]</td>
	</tr>
	<tr>
		<td width="200"><strong>Phone:</strong></td>
		<td>[Phone]</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-top: 20px; font-size: 16px; font-weight: 700;">PROPERTY INFORMATION</td>
	</tr>
	<tr>
		<td><strong>Type of Property:</strong></td>
		<td>[typeofproperty]</td>
	</tr>
	<tr>
		<td><strong>Bedrooms:</strong></td>
		<td>[beds]</td>
	</tr>
	<tr>
		<td><strong>Baths:</strong></td>
		<td>[baths]</td>
	</tr>
</table>
```