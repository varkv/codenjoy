/*-
 * #%L
 * Codenjoy - it's a dojo-like platform from developers to developers.
 * %%
 * Copyright (C) 2016 Codenjoy
 * %%
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public
 * License along with this program.  If not, see
 * <http://www.gnu.org/licenses/gpl-3.0.html>.
 * #L%
 */
using System;
using Game.Api;

namespace YourSolver
{
    /// <summary>
    /// This is Bot client demo.
    /// </summary>
    internal class YourSolver : SolverBase
	{
		private static readonly string Host = "127.0.0.1:8080";
        private static readonly string Name = "kvk@com.com";

		public YourSolver()
            : base(Host, Name)
        {
        }

        /// <summary>
        /// Calls each move to make decision what to do (next move)
        /// </summary>
        protected override string DoMove(Board gameBoard)
        {
            //Just print current state (gameBoard) to console
            Console.Clear();
            Console.SetCursorPosition(0, 0);
            Console.Write(gameBoard.ToString());

            //lets decide what to do
            //just random=)
            Random random = new Random();
            int randomNumber = random.Next(0, 4);
            switch (randomNumber)
            {
                case 0: return ActionToString(Direction.Up);
                case 1: return ActionToString(Direction.Left);
                case 2: return ActionToString(Direction.Right);
                case 3: return ActionToString(Direction.Down);
            }

            return ActionToString(Direction.Down);
        }

        /// <summary>
        /// Starts game client shutdown.
        /// </summary>
        public void InitiateExit()
        {
            ShouldExit = true;
        }
    }
}