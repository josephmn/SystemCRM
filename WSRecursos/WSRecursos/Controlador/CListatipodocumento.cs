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
    public class CListatipodocumento
    {
        public List<EListatipodocumento> Listar_Listatipodocumento(SqlConnection con, Int32 id)
        {
            List<EListatipodocumento> lEListatipodocumento = null;
            SqlCommand cmd = new SqlCommand("ASP_CARGAR_TIPO_DOCUMENTO", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListatipodocumento = new List<EListatipodocumento>();

                EListatipodocumento obEListatipodocumento = null;
                while (drd.Read())
                {
                    obEListatipodocumento = new EListatipodocumento();
                    obEListatipodocumento.i_id = drd["i_id"].ToString();
                    obEListatipodocumento.v_nombre = drd["v_nombre"].ToString();
                    obEListatipodocumento.v_carpeta = drd["v_carpeta"].ToString();
                    obEListatipodocumento.v_type_archivo = drd["v_type_archivo"].ToString();
                    lEListatipodocumento.Add(obEListatipodocumento);
                }
                drd.Close();
            }

            return (lEListatipodocumento);
        }
    }
}