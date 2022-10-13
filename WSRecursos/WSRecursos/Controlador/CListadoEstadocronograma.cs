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
    public class CListadoEstadocronograma
    {
        public List<EListadoEstadocronograma> Listar_ListadoEstadocronograma(SqlConnection con)
        {
            List<EListadoEstadocronograma> lEListadoEstadocronograma = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_ESTADOCRONOGRAMA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListadoEstadocronograma = new List<EListadoEstadocronograma>();

                EListadoEstadocronograma obEListadoEstadocronograma = null;
                while (drd.Read())
                {
                    obEListadoEstadocronograma = new EListadoEstadocronograma();
                    obEListadoEstadocronograma.i_id = drd["i_id"].ToString();
                    obEListadoEstadocronograma.v_nombre = drd["v_nombre"].ToString();
                    lEListadoEstadocronograma.Add(obEListadoEstadocronograma);
                }
                drd.Close();
            }

            return (lEListadoEstadocronograma);
        }
    }
}