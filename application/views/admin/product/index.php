<script type="text/javascript">
	function check_del(){
		if (confirm("Bạn có thực sự muốn xóa [OK]:Yes [Cancel]:No?")) {
        return true;
    	}
    	else{ return false;}
		}
</script>

<div id="content" class="span10">
<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="<?php echo admin_url('home'); ?>">Home Panel</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Quản lý sản phẩm</a></li>
			</ul>

			<?php if(isset($message)) { $this->load->view('admin/message', $this->data); } ?>

<div class="thanhtimkiem">
<form method="GET" action="<?php echo admin_url('product'); ?>">
<div class="span12">
<div style="float: left; padding-right: 15px;">
<div class="control-group">
<div class="controls">
<input class="input-xlarge" id="" type="text" name="name" placeholder="Lọc theo tên...">
</div>
</div>
</div>
<div style="float: left; padding-right: 15px;">
<div class="control-group">
<div class="controls">
<select data-placeholder="Lọc theo danh mục" name="category_id" id="selectError2" data-rel="chosen">
<option value=""></option>
<?php foreach ($category as $row): ?>
<?php if(count($row->subs) > 0 ): ?>
<optgroup label="<?php echo $row->name; ?>">
<?php foreach($row->subs as $sub): ?>
<option value="<?php echo $sub->id; ?>" <?php echo ($this->input->get('category_id') == $sub->id) ? "selected" : "" ?> ><?php echo $sub->name; ?></option>
<?php endforeach; ?>
</optgroup>
<?php else: ?>
<option value="<?php echo $row->id; ?>" <?php echo ($this->input->get('category_id') == $row->id) ? "selected" : "" ?> ><?php echo $row->name; ?></option>
<?php endif; ?>
<?php endforeach; ?>
</select>
</div>
</div>
</div>
<script type="text/javascript">
	function resetall(){
		window.location.href= <?php echo admin_url('product'); ?>
	}
</script>
<div style="float: left;">
<input type="submit" class="btn btn-small btn-inverse" value="Lọc sản phẩm">
<a class="btn btn-small btn-inverse" onclick="return resetall();">Reset</a>
</div>
</div>
</form>
</div>

	<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Danh sách sản phẩm</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>

					</div>
					<div class="box-content">
					<div class="thanh-xuly">
				<a href="<?php echo admin_url('product/add'); ?>" class="btn btn-small btn-success"><i class="halflings-icon white plus"></i> Thêm mới</a>
				
				<span class="list_action" id="list_action">
				<a class="btn btn-small btn-danger" onclick="return xacnhanDelete();" id="submit"><i class="halflings-icon white trash"></i> Xóa tùy chọn</a>
				</span>
					</div>
				<form name="theForm" id="theForm" action="<?php echo admin_url('product/delete_all'); ?>" method="post">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead class="filter">
							  <tr>
							  	  <th>
							  	  <input type="checkbox" name="allbox" id="allbox" onclick="return check_all();" ></th>
								  <th>Tên sản phẩm</th>
								  <th>Hình ảnh</th>
								  <th>Giá</th>
								  <th>Status</th>
								  <th>Ngày tạo</th>
								  <th>Cấu hình</th>
							  </tr>
						  </thead>   
						  <tbody class="list_item">
						 <?php foreach($list as $row) : ?>
							<tr class="row_<?php echo $row->id; ?>">
								<td><input type="checkbox" name="id[]" value="<?php echo $row->id ?>"></td>
								<td><?php echo $row->name ?></td>
								<td class="center"><img src="<?php echo base_url('uploads/product/'.$row->image) ?>" width="70"></td>
								<td class="center"><?php echo number_format($row->price) ?> đ</td>
								<td class="center">
									<?php if($row->is_online==1): ?>
									<span class="label label-success">Actived</span>
								<?php else: ?>
									<span class="label label-important">Offline</span>
								<?php endif; ?>
								</td>
								<td class="center"><?php echo int_to_date($row->created); ?></td>
								<td class="center">
					<a class="btn btn-small btn-info" href="<?php echo admin_url('product/edit/'.$row->id); ?>">
					<i class="halflings-icon white edit"></i>  
					</a>
					<a class="btn btn-small btn-danger" href="<?php echo admin_url('product/del/'.$row->id); ?>" onclick="return check_del();">
					<i class="halflings-icon white trash"></i>  
					</a>
									
								</td>
							</tr>
						<?php endforeach; ?>
						  </tbody>
					  </table> 
					  </form> 
					  <div class="span12 center">
					  <div class="pagination">
					  <?php echo $this->pagination->create_links(); ?>
					  </div>
					 </div>          
					</div>
				</div><!--/span-->
			
			</div><!--/row-->

</div>