<!-- start: CONTENT -->
<section id="content" class="container_12 clearfix" data-sort=true>
	<div class="grid_12 profile">

		<?php

			// Check if service ID is valid
			if ( isset($_GET['id_User']) && $_GET['id_User'] != '' )
			{
				$user_id = decrypted_url($_GET['id_User'] , "**");

				// Load contract information
				$user_info = $modelo->get_user_info_complete($user_id);
			}

			// Check wich information will be used, session or $_GET
			if ( isset($user_id) )
			{
				// Information from $_GET
				$id = $user_info["ID_USUARIO"];
				$name = $user_info["PRIMEIRO_NOME"] . " " . $user_info["SOBRENOME"];
				$user_type = $user_info["ID_TIPO_USUARIO"];
				$photo = $user_info["FOTO"];
				$years = get_idade($user_info["DATA_NASCIMENTO"]) . " anos";
				$born_date = $user_info["DATA_NASCIMENTO"];
				$bloodtype = $user_info["TIPO_SANGUINEO"];
				$email = $user_info["EMAIL"];
				$belt = $user_info["FAIXA"];
				$cpf = $user_info["CPF"];
				$sex = $user_info["SEXO"];
				$phone = $user_info["TELEFONE"];
				$cellphone = $user_info["CELULAR"];

				$cep = $user_info["CEP"];
				$street = $user_info["LOGRADOURO"];
				$number = $user_info["NUMERO"];
				$complement = $user_info["COMPLEMENTO"];
				$neighborhood = $user_info["BAIRRO"];
				$city = $user_info["CIDADE"];
				$state = $user_info["ESTADO"];
			}
			else
			{
				// Information from session
				$id = $this->user_info["ID_USUARIO"];
				$name = $this->user_info["PRIMEIRO_NOME"] . " " . $this->user_info["SOBRENOME"];
				$user_type = $this->user_info["ID_TIPO_USUARIO"];
				$photo = $this->user_info["FOTO"];
				$years = get_idade($this->user_info["DATA_NASCIMENTO"]) . " anos";
				$born_date = $this->user_info["DATA_NASCIMENTO"];
				$bloodtype = $this->user_info["TIPO_SANGUINEO"];
				$email = $this->user_info["EMAIL"];
				$belt = $this->user_info["FAIXA"];
				$cpf = $this->user_info["CPF"];
				$sex = $this->user_info["SEXO"];
				$phone = $this->user_info["TELEFONE"];
				$cellphone = $this->user_info["CELULAR"];

				$cep = $this->user_info["CEP"];
				$street = $this->user_info["LOGRADOURO"];
				$number = $this->user_info["NUMERO"];
				$complement = $this->user_info["COMPLEMENTO"];
				$neighborhood = $this->user_info["BAIRRO"];
				$city = $this->user_info["CIDADE"];
				$state = $this->user_info["ESTADO"];
			}

		?>

		<div class="header">
		
			<div class="title">
				<h2><?php echo $name; ?></h2>
				<h3><?php 

						switch ($user_type) 
						{
							case 1:
								echo "Administrador";
								break;
							case 2:
								echo "Sensei";
								break;
							case 3:
								echo "Aluno";
								break;
							default:
								echo "Usuário";
								break;
						}

				?></h3>
			</div>
			<div class="avatar">
				<img style="height: 75px; width: 75px; border: 2; padding: 0 0 0 0px;" src="
					<?php 

						// Check if the user has a photo
						if ( isset($photo) && strcmp($photo, "") != 0 )
						{
							echo HOME_URI . "/" . $photo;
						}
						else
						{
							echo HOME_URI . "/assets/img/logo.png";
						}

					?>">
			</div>

			<ul class="info">

				<li>
					<a href="javascript:void(0);">
						<strong>FAIXA</strong>
						<small><?php 

							if ( strcmp($belt, "") != 0 )
							{
								echo $belt;
							}
							else
							{
								echo "Não informada";
							}

						?></small>
					</a>
				</li>
				
				<li>
					<a href="javascript:void(0);">
						<strong>IDADE</strong>
						<small><?php 

							if ( strcmp($years, "") != 0 )
							{
								echo $years;
							}
							else
							{
								echo "Não informada";
							}

						?></small>
					</a>
				</li>
				
				<li>
					<a href="javascript:void(0);">
						<strong>TIPO SANGUÍNEO</strong>
						<small><?php 

							if ( strcmp($bloodtype, "") != 0 )
							{
								echo $bloodtype;
							}
							else
							{
								echo "Não informado";
							}

						?></small>
					</a>
				</li>
				
			</ul><!-- End of ul.info -->
		</div><!-- End of .header -->

		<div class="details grid_12">
			<h2>Informações pessoais</h2>
			<?php if ( isset($this->user_info["ID_TIPO_USUARIO"]) && ( $this->user_info["ID_TIPO_USUARIO"] == 1 || $this->user_info["ID_TIPO_USUARIO"] == 2 ) ) { ?>
				<a href="<?php echo encrypted_url($id, HOME_URI . "/modulo_usuario/editar_usuario?id_User="); ?>"><span class="icon icon-pencil"></span>Editar informações do usuário</a>
			<?php } else if ( !isset($user_id) ) { ?>
				<a href="<?php echo encrypted_url($id, HOME_URI . "/modulo_usuario/editar_usuario?id_User="); ?>"><span class="icon icon-pencil"></span>Editar informações do usuário</a>
			<?php } ?>
			<section>
				<table>
					<tr>
						<th>Nome:</th><td><?php 

						if ( strcmp($name, "") != 0 )
						{
							echo $name;
						}
						else
						{
							echo "Não informado";
						}

					?></td>
					</tr>
					<tr>
						<th>E-mail:</th><td><i><?php 

							if ( strcmp($email, "") != 0 )
							{
								echo $email;
							}
							else
							{
								echo "Não informado";
							}

						?></i></td>
					</tr>
					<tr>
						<th>Faixa:</th><td><?php 

							if ( strcmp($belt, "") != 0 )
							{
								echo $belt;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>CPF:</th><td><?php 

							if ( strcmp($cpf, "") != 0 )
							{
								echo $cpf;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Data de nascimento:</th><td><?php 

							if ( strcmp($born_date, "") != 0 )
							{
								echo $born_date;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Sexo:</th><td><?php 

							if ( strcmp($sex, "") != 0 )
							{
								if ( strcmp($sex, "F") == 0 )
									echo "Feminino";
								else
									echo "Masculino";
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Telefone:</th><td><?php 

							if ( strcmp($phone, "") != 0 )
							{
								echo $phone;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Celular:</th><td><?php 

							if ( strcmp($cellphone, "") != 0 )
							{
								echo $cellphone;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
				</table>
			</section>
		</div><!-- End of .details -->
		
		<div class="details grid_12">
			<h2>Endereço</h2>
			<section>
				<table>
					<tr>
						<th>CEP:</th><td><?php

						if ( strcmp($cep, "") != 0 )
							{
								echo $cep;
							}
							else
							{
								echo "Não informado";
							}

					?></td>
					</tr>
					<tr>
						<th>Logradouro:</th><td><?php 

							if ( strcmp($street, "") != 0 )
							{
								echo $street;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Número:</th><td><?php 

							// Check if the user has a photo
							if ( strcmp($number, "") != 0 )
							{
								echo $number;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Complemento:</th><td><?php 

							if ( strcmp($complement, "") != 0 )
							{
								echo $complement;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Bairro:</th><td><?php 

							if ( strcmp($neighborhood, "") != 0 )
							{
								echo $neighborhood;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Cidade:</th><td><?php 

							if ( strcmp($city, "") != 0 )
							{
								echo $city;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
					<tr>
						<th>Estado:</th><td><?php 

							if ( strcmp($state, "") != 0 )
							{
								echo $state;
							}
							else
							{
								echo "Não informado";
							}

						?></td>
					</tr>
				</table>
			</section>
		</div><!-- End of .details -->
		
	</div>
		
	<script>
		$$.ready(function() {				
		// Profile Dialog
		
		$( "#profile-dialog" ).dialog({
			autoOpen: false,
			modal: true,
			width: 400,
			open: function(){ $(this).parent().css('overflow', 'visible'); $$.utils.forms.resize() }
		}).find('button.submit').click(function(){
			var $el = $(this).parents('.ui-dialog-content');
			if ($el.validate().form()) {
				$el.dialog('close');
			}
		}).end().find('button.cancel').click(function(){
			var $el = $(this).parents('.ui-dialog-content');
			$el.find('form')[0].reset();
			$el.dialog('close');;
		});
		
		$( ".open-profile-dialog" ).click(function() {
			$( "#profile-dialog" ).dialog( "open" );
			return false;
		});
	});
	</script>
</section><!-- End of #content -->
<!-- end: CONTENT -->