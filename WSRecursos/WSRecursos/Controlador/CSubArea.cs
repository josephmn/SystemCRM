using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CSubArea
    {
        public List<ESubArea> Listar_SubArea(SqlConnection con, Int32 post, String area)
        {
            List<ESubArea> lESubArea = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_SUBAREA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@area", SqlDbType.VarChar).Value = area;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lESubArea = new List<ESubArea>();

                ESubArea obESubArea = null;
                while (drd.Read())
                {
                    obESubArea = new ESubArea();
                    obESubArea.i_id = drd["i_id"].ToString();
                    obESubArea.v_descripcion = drd["v_descripcion"].ToString();
                    obESubArea.v_default = drd["v_default"].ToString();
                    lESubArea.Add(obESubArea);
                }
                drd.Close();
            }

            return (lESubArea);
        }
    }
}