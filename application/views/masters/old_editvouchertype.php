<?php $this->load->view("common/meta");?>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Data
        <small>Edit Voucher</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php if(in_array('vouchersedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
        <div class="col-md-4">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Voucher</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="<?php echo site_url("masters/edit_vouchertype/").$rec[0]['vid']?>" method="post">
            <div class="box-body">
              <?php
              if($this->session->flashdata('success')){
              ?>
              <div class="alert alert-dismissable alert-success">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
              </div>
              <?php
              }
              
              if($this->session->flashdata('error')){
              ?>
              <div class="alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
              </div>
              <?php
              }
              ?>
                
                
              <div class="form-group">
              <label for="voucher_type">Voucher Type:</label>
              <select class="form-control form-control-sm" name="voucher_type" id="voucher_type">
                <option value="Quotation" <?=$rec[0]['voucher_type']=='Quotation'?'selected':'';?>>Quotation</option>
                <option value="Sale Order" <?=$rec[0]['voucher_type']=='Sale Order'?'selected':'';?>>Sale Order</option>
                <option value="Purchase Order" <?=$rec[0]['voucher_type']=='Purchase Order'?'selected':'';?>>Purchase Order</option>
                <option value="Expenses" <?=$rec[0]['voucher_type']=='Expenses'?'selected':'';?>>Expenses</option>
                <option value="Enquiry" <?=$rec[0]['voucher_type']=='Enquiry'?'selected':'';?>>Enquiry</option>
              </select>  
            </div>

            <div class="form-group">
              <label for="level_number">Enter Level (1-4):</label>
              <input type="number" id="level_number" name="level_number" class="form-control form-control-sm" placeholder="Enter a level number (1-4)" min="1" max="4" value="<?=$rec[0]['level_number'];?>">
            </div>

            <div class="input-container" id="dynamic_inputs">
              <!-- Dynamic input fields will appear here -->
            </div>
            </div>
            <div class="box-footer">
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Submit</button>
            </div>
            </form>
          </div>
        </div>
        <?php }?>
       
      </div>
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
<script type="text/javascript">
  $('.clockpick').clockpicker({
            autoclose:true
        });
</script>
  <script>
  document.getElementById('level_number').addEventListener('input', function () {
    populateFields(this.value);
  });

  // Function to populate fields based on level and existing data
  function populateFields(level) {
    const container = document.getElementById('dynamic_inputs');
    container.innerHTML = ''; // Clear previous inputs

    const parsedLevel = parseInt(level);
    if (parsedLevel >= 1 && parsedLevel <= 4) {
      for (let i = 1; i <= parsedLevel; i++) {
        // Create a div to hold the label, select, and list of selected items
        const fieldDiv = document.createElement('div');
        fieldDiv.className = 'form-group';

        // Add label for the field
        const label = document.createElement('label');
        label.textContent = `Field ${i}:`;

        // Create a select dropdown
        const select = document.createElement('select');
        select.className = 'form-control form-control-sm';
        select.name = `field_select_${i}`;
        select.innerHTML = `
          <option value="">Select Employee</option>
          <?php foreach ($employees as $employee): ?>
            <option value="<?php echo $employee['employee_name']; ?>"><?php echo $employee['employee_name']; ?></option>
          <?php endforeach; ?>
        `;

        // Add button to add the selected option
        const addButton = document.createElement('button');
        addButton.textContent = 'Add';
        addButton.type = 'button';
        addButton.className = 'btn btn-sm btn-primary ml-2';
        addButton.addEventListener('click', function () {
          const selectedValue = select.value;
          if (selectedValue) {
            // Check for duplicate entries
            const existingItems = Array.from(selectedList.querySelectorAll('li'));
            if (existingItems.some(item => item.textContent === selectedValue)) {
              alert('This employee is already added.');
              return;
            }

            // Add selected value to the list
            const listItem = document.createElement('li');
            listItem.textContent = selectedValue;

            // Hidden input for storing values
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `field_values[${i}][]`; // Ensure proper structure
            hiddenInput.value = selectedValue;

            listItem.appendChild(hiddenInput);
            selectedList.appendChild(listItem);

            select.value = ''; // Reset the dropdown
          } else {
            alert('Please select an employee to add.');
          }
        });

        // Create a list to display selected items
        const selectedList = document.createElement('ul');
        selectedList.className = 'selected-list';

        // Prepopulate the selected employees
        const existingValues = <?php echo json_encode($existingFieldValues ?? []); ?>;
        if (existingValues[i]) {
          existingValues[i].forEach(value => {
            const listItem = document.createElement('li');
            listItem.textContent = value;

            // Hidden input for storing values
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `field_values[${i}][]`;
            hiddenInput.value = value;

            listItem.appendChild(hiddenInput);
            selectedList.appendChild(listItem);
          });
        }

        // Append label, select, button, and list to the fieldDiv
        fieldDiv.appendChild(label);
        fieldDiv.appendChild(select);
        fieldDiv.appendChild(addButton);
        fieldDiv.appendChild(selectedList);

        container.appendChild(fieldDiv);
      }
    } else if (level) {
      alert('Please enter a level between 1 and 4.');
    }
  }

  // Call the populateFields function on page load with the current level number
  window.addEventListener('load', function () {
    const currentLevel = document.getElementById('level_number').value;
    if (currentLevel) {
      populateFields(currentLevel);
    }
  });
</script>


</body> 
</html>