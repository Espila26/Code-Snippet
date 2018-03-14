    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </div>
<!-- ./wrapper -->

<!-- Modal -->
<div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">About Hoard</h4>
      </div>
      <div class="modal-body">
	      <p><strong>Version PRE-ALPHA</strong></p>
	      
	      <p>Hoard is a code snippet manager designed for teams. Develop faster and work more efficiently with your own library of useful code snippets and references.</p>
	      
	      <p><strong><small>&copy; Adam Greenough 2017.<br />
	      Licensed under the GNU General Public License v3.0.<br />
	      All rights reserved.</small></strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-github"></i> GitHub Repo</button>
        <button type="button" class="btn btn-warning"><i class="fa fa-link"></i> Visit Website</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/assets/vendor/plugins/fastclick/fastclick.min.js"></script>
<script src="/assets/vendor/plugins/select2/select2.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/js/adminlte.min.js"></script>
<script src="/assets/js/app.js"></script>

<script src="/assets/vendor/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script>
	$(".my-colorpicker1").colorpicker();
	$('.sidebar').perfectScrollbar({ wheelPropagation: true, });
</script>

<script>
	$(document).ready(function () {    
    var CurrentUrl = $(location).attr('href');
    $('.sidebar-menu li a').each(function(Key,Value)
        {
	        console.log(CurrentUrl);
	        
            if(CurrentUrl.includes(Value['href']))
            {
	            console.log('true');
                $(Value).parent().addClass('active');
            }
            
            if((Value['href'] == '<?php echo $baseurl; ?>/index.php') && (CurrentUrl === '<?php echo $baseurl; ?>/'))
            {
	            console.log('true');
                $(Value).parent().addClass('active');
            }
        });
 });
 </script>
</body>
</html>