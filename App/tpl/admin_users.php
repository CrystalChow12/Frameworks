<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>All Users</title>

		<link rel="stylesheet" href="../../css/output.css" />
	</head>

	<body class="bg-gray-100">
		<div class="flex">
			<?php include 'partials/sidebar.php'; ?>

			<div class="flex-1 flex flex-col overflow-hidden">
				<?php include 'partials/header.php'; ?>
				
				<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
					<div class="mx-auto p-5">
						<h3 class="text-gray-700 text-3xl font-medium">User Records</h3>
						<br />
						<div
							class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-11/12 mx-auto"
						>
							<div class="flex-1 overflow-y-auto">
								
				  			<?php if (isset($messages) && !empty($messages)): ?>
								<?php foreach ($messages as $message): ?>
									<p class="text-base text-center font-medium text-green-700"><?= htmlspecialchars($message) ?></p>
								<?php endforeach; ?>
							<?php endif; ?>
                
								<!---TABLE STARTS HERE--->

								<div class="flex flex-col">
									<div class="m-1.5 overflow-x-auto">
										<div class="p-1.5 min-w-full inline-block align-middle">
											<div class="py-6 px-4">
												
										
											</div>
											
											<div class="overflow-hidden">
												<table class="min-w-full divide-y divide-gray-200">
												
													<thead class="bg-gray-50">
														<tr class="align-middle">
														<th
																scope="col"
																class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase"
																>Username</th
															>
															<th
																scope="col"
																class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase"
																>Email</th
															>
															<th
																scope="col"
																class="py-3 px-16 text-xs text-center font-medium text-gray-500 uppercase"
																>Role</th
															>

															<th
																scope="col"
																class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase"
																>Action</th
															>
														</tr>
													</thead>
												
													<tbody class="divide-y divide-gray-200">
														<?php if (isset($users) && !empty($users)): ?>
															<?php foreach ($users as $user): ?>

															<tr>
																<td
																	class="px-14 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
																	><?= htmlspecialchars($user['username']) ?></td
																>
																<td
																	class="px-14 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
																	><?= htmlspecialchars($user['email']) ?></td
																>
																<td class="text-center py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($user['role']) ?></td>

																<td class="px-12 py-4 whitespace-nowrap text-center text-sm font-medium">
																<form action="/admin/users/delete?id=<?= htmlspecialchars($user['id']) ?>" method="POST">
																	<button
																		type="submit"
																		class="inline-flex items-center gap-x-1 pr-1 text-sm font-semibold rounded-lg border border-transparent text-cyan-500 hover:text-cyan-700 focus:outline-none focus:text-cyan-700 disabled:opacity-50 disabled:pointer-events-none"
																		>Delete</button>
																</form>
																	
																</td>
															</tr>
														<?php endforeach; ?>
															<?php else: ?>
																<p>There has been an error generating employees.</p>
														<?php endif; ?>
													</tbody>
												</table>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
		<script src="../../js/register.js" defer></script>
	</body>
</html>
