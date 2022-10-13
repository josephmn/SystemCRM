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
    public class CListarFlexTime
    {
        public List<EListarFlexTime> ListarFlexTime(SqlConnection con, Int32 id, Int32 idflex, Int32 zona, Int32 local)
        {
            List<EListarFlexTime> lEListarFlexTime = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_FLEXTIME", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;
            cmd.Parameters.AddWithValue("@idflex", SqlDbType.Int).Value = idflex;
            cmd.Parameters.AddWithValue("@zona", SqlDbType.Int).Value = zona;
            cmd.Parameters.AddWithValue("@local", SqlDbType.Int).Value = local;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarFlexTime = new List<EListarFlexTime>();

                EListarFlexTime obEListarFlexTime = null;
                while (drd.Read())
                {
                    obEListarFlexTime = new EListarFlexTime();
                    obEListarFlexTime.i_id = Convert.ToInt32(drd["i_id"].ToString());
                    obEListarFlexTime.v_nombre = drd["v_nombre"].ToString();
                    obEListarFlexTime.v_hora_inicio = drd["v_hora_inicio"].ToString();
                    obEListarFlexTime.v_hora_fin = drd["v_hora_fin"].ToString();
                    obEListarFlexTime.v_tolerancia = drd["v_tolerancia"].ToString();
                    obEListarFlexTime.i_zona = Convert.ToInt32(drd["i_zona"].ToString());
                    obEListarFlexTime.v_zona = drd["v_zona"].ToString();
                    obEListarFlexTime.i_estado = Convert.ToInt32(drd["i_estado"].ToString());
                    obEListarFlexTime.v_estado = drd["v_estado"].ToString();
                    obEListarFlexTime.v_color_estado = drd["v_color_estado"].ToString();
                    obEListarFlexTime.i_local = Convert.ToInt32(drd["i_local"].ToString());
                    obEListarFlexTime.v_local = drd["v_local"].ToString();
                    lEListarFlexTime.Add(obEListarFlexTime);
                }
                drd.Close();
            }

            return (lEListarFlexTime);
        }
    }
}