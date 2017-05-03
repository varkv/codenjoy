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
﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Game.Api
{
    public class Board
    {
        public Board(String boardString)
        {
            BoardString = boardString.Replace("\n", "");
        }

        public String BoardString { get; private set; }

        /// <summary>
        /// GameBoard size (actual board size is Size x Size cells)
        /// </summary>
        public int Size
        {
            get
            {
                return (int)Math.Sqrt(BoardString.Length);
            }
        }

		public List<BoardPoint> Apples
		{
			get
			{
				return FindAllElements(BoardElement.GoodApple).ToList();
			}
		}

        /// <summary>
        /// if head is null you already died=(
        /// just skip step
        /// </summary>
		public BoardPoint? Head
		{           
			get
			{
                List<BoardPoint> result = FindAllElements(BoardElement.HeadUp)
                    .Concat(FindAllElements(BoardElement.HeadDown))
                    .Concat(FindAllElements(BoardElement.HeadLeft))
                    .Concat(FindAllElements(BoardElement.HeadRight))
                    .ToList();
				if(result.Count == 0)
                {
                    return null;
                }
                return result.Single();

			}
		}

		public List<BoardPoint> Snake
		{
			get
			{
				BoardPoint? head = Head;
				if (head == null)
				{
					return new List<BoardPoint>();
				}
				List<BoardPoint> result = FindAllElements(BoardElement.TailEndDown)
					.Concat(FindAllElements(BoardElement.TailEndLeft))
					.Concat(FindAllElements(BoardElement.TailEndRight))
					.Concat(FindAllElements(BoardElement.TailEndUp))
					.Concat(FindAllElements(BoardElement.TailHorizontal))
					.Concat(FindAllElements(BoardElement.TailVertical))
					.Concat(FindAllElements(BoardElement.TailLeftDown))
					.Concat(FindAllElements(BoardElement.TailRightDown))
					.Concat(FindAllElements(BoardElement.TailRightUp))
					.ToList();

                result.Insert(0, head.GetValueOrDefault());
				return result;
			}
		}

		public List<BoardPoint> Stones
		{
			get
			{
				return FindAllElements(BoardElement.BadApple)
					.ToList();
			}
		}

		public List<BoardPoint> Walls
		{
			get
			{
				return FindAllElements(BoardElement.Break)
					.ToList();
			}
		}

		public Direction GetSnakeDirection()
		{
			BoardPoint? head = Head;
			if (head == null)
			{
				return Direction.Left;
			}
			if (HasElementAt(head.GetValueOrDefault(), BoardElement.HeadUp))
			{
				return Direction.Up;
			}
			else if (HasElementAt(head.GetValueOrDefault(), BoardElement.HeadDown))
			{
				return Direction.Down;
			}
			else if (HasElementAt(head.GetValueOrDefault(), BoardElement.HeadRight))
			{
				return Direction.Right;
			}

			return Direction.Left;
		}

		public List<BoardPoint> GetBarriers()
		{
			return Snake
					.Concat(Stones)
					.Concat(Walls)
					.ToList();
		}


		public override string ToString() 
		{
            return String.Format("Board:{0}{1}{0}" +
                "Apple at: {2}{0}" +
                "Stones at: {3}{0}" +
                "Head at: {4}{0}" +
                "Snake at: {5}{0}" +
                "Barriers at: {6}{0}" +
                "Current direction: {7}",
                    System.Environment.NewLine,
                    PrintBoard(),
                    PrintList(Apples),
                    PrintList(Stones),
                    Head.ToString(),
                    PrintList(Snake),
                    PrintList(GetBarriers()),
                    GetSnakeDirection());
		}


		//default enginie methods------------------------------------------------

		public bool HasElementAt(BoardPoint point, BoardElement element)
        {
            if (point.IsOutOfBoard(Size))
            {
                return false;
            }

            return GetElementAt(point) == element;
        }

        public BoardElement GetElementAt(BoardPoint point)
        {
            return (BoardElement)BoardString[GetShiftByPoint(point)];
        }

        /// <summary>
        /// Writes board view to the console window
        /// </summary>
        public String PrintBoard()
        {
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < Size; i++)
            {
                sb.Append(BoardString.Substring(i * Size, Size));
                sb.Append(System.Environment.NewLine);
            }
            return sb.ToString();
        }

        public String PrintList<T>(List<T> list)
        {
            StringBuilder sb = new StringBuilder();
            sb.Append("[");
            foreach (var item in list)
            {
                sb.Append(item.ToString());
                sb.Append(",");
            }
            if (list.Count > 0)
            {
                sb.Remove(sb.Length - 1, 1);
            }
            sb.Append("]");
            return sb.ToString();
        }

        public List<BoardPoint> FindAllElements(BoardElement element)
        {
            List<BoardPoint> result = new List<BoardPoint>();

            for (int i = 0; i < Size * Size; i++)
            {
                BoardPoint pt = GetPointByShift(i);

                if (HasElementAt(pt, element))
                {
                    result.Add(pt);
                }
            }

            return result;
        }
		
        public bool HasElementAt(BoardPoint point, params BoardElement[] elements)
        {
            return elements.Any(elem => HasElementAt(point, elem));
        }

        public bool IsNearToElement(BoardPoint point, BoardElement element)
        {
            if (point.IsOutOfBoard(Size))
                return false;

            return HasElementAt(point.ShiftBottom(), element)
                   || HasElementAt(point.ShiftTop(), element)
                   || HasElementAt(point.ShiftLeft(), element)
                   || HasElementAt(point.ShiftRight(), element);
        }

        public bool HasBarrierAt(BoardPoint point)
        {
            return GetBarriers().Contains(point);
        }

        public int GetCountElementsNearToPoint(BoardPoint point, BoardElement element)
        {
            if (point.IsOutOfBoard(Size))
                return 0;

            //GetHashCode() in classic MS.NET for bool returns 1 for true and 0 for false;
            return HasElementAt(point.ShiftLeft(), element).GetHashCode() +
                   HasElementAt(point.ShiftRight(), element).GetHashCode() +
                   HasElementAt(point.ShiftTop(), element).GetHashCode() +
                   HasElementAt(point.ShiftBottom(), element).GetHashCode();
        }

        private int GetShiftByPoint(BoardPoint point)
        {
            return point.Y * Size + point.X;
        }

        private BoardPoint GetPointByShift(int shift)
        {
            return new BoardPoint(shift % Size, shift / Size);
        }


    }
}