	<div class="col-xl-12">
		<div class="shadow-lg card">
			<div class="card-body pb-xl-4 pb-sm-3 pb-0">	
				<div class="row" >
					<div class="col-xl-3 col-6">
						<div class="content-box">
							<div class="icon-box icon-box-xl std-data">
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="white" class="bi bi-card-checklist" viewBox="0 0 16 16">
								<path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
								<path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0"/>
							</svg>
							</div>
							<div  class="chart-num">
								<p style="font-size: 15px;">ATELIERS</p>
								<h2 class="font-w700 mb-0">
									<?=$nbre = $atelier -> NbreAtelier($conn); ?>
								</h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-6">
						<div class="content-box">
							<div class="teach-data icon-box icon-box-xl">
							<span class="material-symbols-outlined">science</span>
							</div>
							<div class="chart-num">
								<p style="font-size: 15px;">PRODUITS</p>
								<h2 class="font-w700 mb-0">
									<?=$produit->NbreProduits($conn)?>
								</h2>
							</div>
						</div>
					</div>
					
					<!-- <div class="col-xl-3 col-6">
						<div class="content-box">
							<div class="event-data icon-box icon-box-xl">
								<svg width="20" height="20" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M24 2.75H21.5V1.5C21.5 1.16848 21.3683 0.850537 21.1339 0.616117C20.8995 0.381696 20.5815 0.25 20.25 0.25C19.9185 0.25 19.6005 0.381696 19.3661 0.616117C19.1317 0.850537 19 1.16848 19 1.5V2.75H15.25V1.5C15.25 1.16848 15.1183 0.850537 14.8839 0.616117C14.6495 0.381696 14.3315 0.25 14 0.25C13.6685 0.25 13.3505 0.381696 13.1161 0.616117C12.8817 0.850537 12.75 1.16848 12.75 1.5V2.75H9V1.5C9 1.16848 8.8683 0.850537 8.63388 0.616117C8.39946 0.381696 8.08152 0.25 7.75 0.25C7.41848 0.25 7.10054 0.381696 6.86612 0.616117C6.6317 0.850537 6.5 1.16848 6.5 1.5V2.75H4C3.00544 2.75 2.05161 3.14509 1.34835 3.84835C0.645088 4.55161 0.25 5.50544 0.25 6.5V24C0.25 24.9946 0.645088 25.9484 1.34835 26.6517C2.05161 27.3549 3.00544 27.75 4 27.75H24C24.9946 27.75 25.9484 27.3549 26.6517 26.6517C27.3549 25.9484 27.75 24.9946 27.75 24V6.5C27.75 5.50544 27.3549 4.55161 26.6517 3.84835C25.9484 3.14509 24.9946 2.75 24 2.75ZM2.75 6.5C2.75 6.16848 2.8817 5.85054 3.11612 5.61612C3.35054 5.3817 3.66848 5.25 4 5.25H6.5V6.5C6.5 6.83152 6.6317 7.14946 6.86612 7.38388C7.10054 7.6183 7.41848 7.75 7.75 7.75C8.08152 7.75 8.39946 7.6183 8.63388 7.38388C8.8683 7.14946 9 6.83152 9 6.5V5.25H12.75V6.5C12.75 6.83152 12.8817 7.14946 13.1161 7.38388C13.3505 7.6183 13.6685 7.75 14 7.75C14.3315 7.75 14.6495 7.6183 14.8839 7.38388C15.1183 7.14946 15.25 6.83152 15.25 6.5V5.25H19V6.5C19 6.83152 19.1317 7.14946 19.3661 7.38388C19.6005 7.6183 19.9185 7.75 20.25 7.75C20.5815 7.75 20.8995 7.6183 21.1339 7.38388C21.3683 7.14946 21.5 6.83152 21.5 6.5V5.25H24C24.3315 5.25 24.6495 5.3817 24.8839 5.61612C25.1183 5.85054 25.25 6.16848 25.25 6.5V10.25H2.75V6.5ZM25.25 24C25.25 24.3315 25.1183 24.6495 24.8839 24.8839C24.6495 25.1183 24.3315 25.25 24 25.25H4C3.66848 25.25 3.35054 25.1183 3.11612 24.8839C2.8817 24.6495 2.75 24.3315 2.75 24V12.75H25.25V24Z" fill="white"/>
								</svg>	
							</div>
							<div class="chart-num">
								<p style="font-size: 15px;">Matiere</p>
								<h2 class="font-w700 mb-0">

								</h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-6">
						<div class="content-box">
							<div class="food-data icon-box icon-box-xl bg-dark">
							<svg width="20" height="20" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M24 2.75H21.5V1.5C21.5 1.16848 21.3683 0.850537 21.1339 0.616117C20.8995 0.381696 20.5815 0.25 20.25 0.25C19.9185 0.25 19.6005 0.381696 19.3661 0.616117C19.1317 0.850537 19 1.16848 19 1.5V2.75H15.25V1.5C15.25 1.16848 15.1183 0.850537 14.8839 0.616117C14.6495 0.381696 14.3315 0.25 14 0.25C13.6685 0.25 13.3505 0.381696 13.1161 0.616117C12.8817 0.850537 12.75 1.16848 12.75 1.5V2.75H9V1.5C9 1.16848 8.8683 0.850537 8.63388 0.616117C8.39946 0.381696 8.08152 0.25 7.75 0.25C7.41848 0.25 7.10054 0.381696 6.86612 0.616117C6.6317 0.850537 6.5 1.16848 6.5 1.5V2.75H4C3.00544 2.75 2.05161 3.14509 1.34835 3.84835C0.645088 4.55161 0.25 5.50544 0.25 6.5V24C0.25 24.9946 0.645088 25.9484 1.34835 26.6517C2.05161 27.3549 3.00544 27.75 4 27.75H24C24.9946 27.75 25.9484 27.3549 26.6517 26.6517C27.3549 25.9484 27.75 24.9946 27.75 24V6.5C27.75 5.50544 27.3549 4.55161 26.6517 3.84835C25.9484 3.14509 24.9946 2.75 24 2.75ZM2.75 6.5C2.75 6.16848 2.8817 5.85054 3.11612 5.61612C3.35054 5.3817 3.66848 5.25 4 5.25H6.5V6.5C6.5 6.83152 6.6317 7.14946 6.86612 7.38388C7.10054 7.6183 7.41848 7.75 7.75 7.75C8.08152 7.75 8.39946 7.6183 8.63388 7.38388C8.8683 7.14946 9 6.83152 9 6.5V5.25H12.75V6.5C12.75 6.83152 12.8817 7.14946 13.1161 7.38388C13.3505 7.6183 13.6685 7.75 14 7.75C14.3315 7.75 14.6495 7.6183 14.8839 7.38388C15.1183 7.14946 15.25 6.83152 15.25 6.5V5.25H19V6.5C19 6.83152 19.1317 7.14946 19.3661 7.38388C19.6005 7.6183 19.9185 7.75 20.25 7.75C20.5815 7.75 20.8995 7.6183 21.1339 7.38388C21.3683 7.14946 21.5 6.83152 21.5 6.5V5.25H24C24.3315 5.25 24.6495 5.3817 24.8839 5.61612C25.1183 5.85054 25.25 6.16848 25.25 6.5V10.25H2.75V6.5ZM25.25 24C25.25 24.3315 25.1183 24.6495 24.8839 24.8839C24.6495 25.1183 24.3315 25.25 24 25.25H4C3.66848 25.25 3.35054 25.1183 3.11612 24.8839C2.8817 24.6495 2.75 24.3315 2.75 24V12.75H25.25V24Z" fill="white"/>
								</svg>	
							</div>
							<div class="chart-num">
								<p style="font-size: 15px;">Filière</p>
								<h2 class="font-w700 mb-0">
								
								</h2>
							</div>
						</div>
					</div> -->
				</div>	
			</div>
		</div>
	</div>
</div>