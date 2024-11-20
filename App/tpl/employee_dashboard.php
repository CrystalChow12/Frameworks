<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Employee Tasks</title>

		<link rel="stylesheet" href="../../css/output.css" />
	</head>

	<body class="bg-gray-100">
		<div class="flex">
			<?php include 'partials/empSidebar.php'; ?>

			<div class="flex-1 flex flex-col overflow-hidden">
				<?php include 'partials/header.php'; ?>
				
				<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
					<div class="mx-auto p-5">
						<h3 class="text-gray-700 text-3xl font-medium">Your Tasks</h3>
						<br />
						<div
							class="bg-white shadow-sm border border-gray-300 rounded-lg overflow-hidden w-12/12 mx-auto"
						>
							<div class="flex-1 overflow-y-auto">
								
								<!---TABLE STARTS HERE--->

								<div class="flex flex-col">
									<div class="m-1.5 overflow-x-auto">
										<div class="p-1.5 min-w-full inline-block align-middle">
											<div class="py-3 px-4">
												
											</div>
											<div class="overflow-hidden">
												<table class="min-w-full divide-y divide-gray-200">
												
													<thead class="bg-gray-50">
														<tr class="align-middle">
														<th
																scope="col"
																class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase"
																>Task</th
															>
														
															<th
																scope="col"
																class="py-3 px-14 text-xs text-start font-medium text-gray-500 uppercase"
																>Manager</th
															>

															<th
																scope="col"
																class="py-3 px-16 text-xs text-center font-medium text-gray-500 uppercase"
																>Due Date</th
															>

                                                            <th
																scope="col"
																class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase"
																>Added Comments</th
															>

															<th
																scope="col"
																class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase"
																>Status</th
															>

                                                            <th
																scope="col"
																class="py-3 px-14 text-xs text-center font-medium text-gray-500 uppercase"
																>Action</th
															>

														</tr>
													</thead>
												
													<tbody class="divide-y divide-gray-200">
														<?php if (isset($tasks) && !empty($tasks)): ?>
															<?php foreach ($tasks as $task): ?>

															<tr>
																<td
																	class="px-14 py-4 whitespace-nowrap text-sm font-medium text-gray-800"
																	><?= htmlspecialchars($task['description']) ?></td
																>
																<td
																	class="px-14 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800"
																	><?= htmlspecialchars($task['manager_username']) ?></td
																>

																<td
																	class="px-14 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800"
																	><?= htmlspecialchars($task['due_date']) ?></td
																>
																<td class="text-center py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars($task['comments']) ?></td>

                                                                
                                                                <td class="text-center py-4 whitespace-nowrap text-sm text-gray-800"><?= htmlspecialchars(
                                                                	$task['status'],
                                                                ) ?></td>


                                                                

                                                                <td class="px-12 py-4 whitespace-nowrap text-center text-sm font-medium">   
                                                                
                                                                    <button
                                                                        type="button"
                                                                        class="inline-flex items-center gap-x-1 pr-1 text-sm font-semibold rounded-lg border border-transparent text-cyan-500 hover:text-cyan-700 focus:outline-none focus:text-cyan-700 disabled:opacity-50 disabled:pointer-events-none"
                                                                        ><a href="/employee/tasks/edit?id=<?= htmlspecialchars(
                                                                        	$task['id'],
                                                                        ) ?>">Edit</a></button
                                                                    >
                                                                </td>


													
															</tr>
														<?php endforeach; ?>
															<?php else: ?>
																<p class="mb-6">You have no assigned tasks.</p>

														<?php endif; ?>
													</tbody>
												</table>
											</div>
											<div class="py-1 px-4">
												<nav class="flex items-center space-x-1" aria-label="Pagination">
													<button
														type="button"
														class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
														aria-label="Previous"
													>
														<span aria-hidden="true">«</span>
														<span class="sr-only">Previous</span>
													</button>
													<button
														type="button"
														class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
														aria-current="page">1</button
													>
													<button
														type="button"
														class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
														>2</button
													>
													<button
														type="button"
														class="min-w-[40px] flex justify-center items-center text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 py-2.5 text-sm rounded-full disabled:opacity-50 disabled:pointer-events-none"
														>3</button
													>
													<button
														type="button"
														class="p-2.5 min-w-[40px] inline-flex justify-center items-center gap-x-2 text-sm rounded-full text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none"
														aria-label="Next"
													>
														<span class="sr-only">Next</span>
														<span aria-hidden="true">»</span>
													</button>
												</nav>
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
